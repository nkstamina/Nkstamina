<?php

namespace Nkstamina\Framework;

use Nkstamina\Framework\Controller\ControllerResolver;
use Nkstamina\Framework\Provider\ConfigServiceProvider;
use Nkstamina\Framework\Provider\RoutingServiceProvider;
use Pimple\ServiceProviderInterface;
use Pimple\Container;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\EventListener\RouterListener;
use Symfony\Component\HttpKernel\HttpKernel;
use Symfony\Component\HttpKernel\HttpKernelInterface;

/**
 * Class Application
 * @package Nkstamina\Framework
 */
class Application extends Container implements HttpKernelInterface
{
    const VERSION = '0.0.0-DEV';

    const EARLY_EVENT = 512;
    const LATE_EVENT  = -512;

    protected $providers = [];
    protected $booted = false;

    /**
     * Constructor
     *
     * @param array $values
     */
    public function __construct(array $values = [])
    {
        parent::__construct($values);

        $app = $this;

        $this['env'] = getenv('APP_ENV') ?: 'prod';
        $this['request.http_port'] = 80;
        $this['request.https_port'] = 443;
        $this['debug'] = false;
        $this['charset'] = 'UTF-8';
        $this['logger'] = null;
        $this['use_cache'] = false;

        $this['resolver'] = function () use ($app) {
            return new ControllerResolver($app, $app['logger']);
        };

        $this['event_dispatcher_class'] = 'Symfony\\Component\\EventDispatcher\\EventDispatcher';
        $this['dispatcher'] = function () use ($app) {
            return new $app['event_dispatcher_class'];
        };

        $this['kernel'] = function () use ($app) {
            return new HttpKernel($app['dispatcher'], $app['resolver']);
        };

        $this->register(new ConfigServiceProvider($app));
        $this->register(new RoutingServiceProvider($app));

        $this['dispatcher']->addSubscriber(new RouterListener($app['matcher']));

        foreach ($values as $key => $value) {
            $this[$key] = $value;
        }
    }

    /**
     * Registers a service provider.
     *
     * @param ServiceProviderInterface $provider
     * @param array                    $values
     * @throws \InvalidArgumentException
     *
     * @return $this|static
     */
    public function register(ServiceProviderInterface $provider, array $values = [])
    {
        $this->providers[] = $provider;

        parent::register($provider, $values);

        return $this;
    }

    /**
     * Boots all providers
     *
     * @return bool
     */
    public function boot()
    {
        if (!$this->booted) {
            foreach ($this->providers as $provider) {
                $provider->boot($this);
            }
        }

        $this->booted = true;
    }

    /**
     * {@inheritdoc}
     */
    public function handle(Request $request, $type = HttpKernelInterface::MASTER_REQUEST, $catch = true)
    {
        if (!$this->booted) {
            $this->boot();
        }

        $this['request'] = $request;
        $request->attributes->add($this['matcher']->match($request->getPathInfo()));

        return $this['kernel']->handle($request, $type, $catch);
    }

    /**
     * Handles the request and delivers the response.
     *
     * @param Request|null $request Request to process
     */
    public function run(Request $request = null)
    {
        if (null === $request) {
            $request = Request::createFromGlobals();
        }

        $response = $this->handle($request);
        $response->send();
        $this->terminate($request, $response);
    }

    /**
     * {@inheritdoc}
     */
    public function terminate(Request $request, Response $response)
    {
        $this['kernel']->terminate($request, $response);
    }

    /**
     * Returns providers
     *
     * @return array
     */
    public function getProviders()
    {
        return $this->providers;
    }
}