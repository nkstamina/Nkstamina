<?php

namespace Nkstamina\Framework;

use Nkstamina\Framework\Controller\ControllerResolver;
use Nkstamina\Framework\Provider\RoutingServiceProvider;
use Nkstamina\Framework\ServiceProviderInterface;
use Pimple\Container;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\HttpKernelInterface;

/**
 * Class Application
 * @package Nkstamina\Framework
 */
class Application extends Container implements HttpKernelInterface
{
    const VERSION = '0.0.0-DEV';

    const EARLY_EVENT = 512;
    const LATE_EVENT = -512;

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

        $this['request.http_port'] = 80;
        $this['request.https_port'] = 443;
        $this['debug'] = false;
        $this['charset'] = 'UTF-8';
        $this['logger'] = null;


        $this['resolver'] = function () use ($app) {
            return new ControllerResolver($app, $app['logger']);
        };



        $this->register(new RoutingServiceProvider());
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
        if (is_string($provider)) {
            $provider = new $provider;
        }

        if(!$provider instanceof ServiceProviderInterface) {
            throw new \InvalidArgumentException('Provider must implement the ServiceProviderInterface');
        }

        $this->providers[] = $provider;

        parent::register($provider, $values);

        return $this;
    }

    /**
     * Boots all service providers
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

        return $this['router']->handle($request, $type, $catch);
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
        $this['router']->terminate($request, $response);
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