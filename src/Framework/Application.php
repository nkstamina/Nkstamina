<?php

namespace Nkstamina\Framework;

use Nkstamina\Framework\Controller\ControllerResolver;
use Nkstamina\Framework\Provider\ConfigServiceProvider;
use Nkstamina\Framework\Provider\RoutingServiceProvider;
use Nkstamina\Framework\Provider\TemplatingServiceProvider;
use Pimple\ServiceProviderInterface;
use Pimple\Container;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\EventListener\RouterListener;
use Symfony\Component\HttpKernel\HttpKernel;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\Finder\Finder;

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

    protected $extensions = [];

    /**
     * Constructor
     *
     * @param array $values
     */
    public function __construct(array $values = [])
    {
        parent::__construct($values);

        $app = $this;

        $this['app.root.dir']       = realpath(__DIR__ . '/../../../../../');
        $this['app.extensions.dir'] = $this['app.root.dir'] . '/extensions';
        $this['app.dir']            = $this['app.root.dir'] . '/app';
        $this['app.config.dir']     = $this['app.dir'] . '/config';
        $this['app.cache.dir']      = $this['app.dir'] . '/cache';

        // to switch between prod & dev
        // just set the APP_ENV environment variable:
        // in apache: SetEnv APP_ENV dev
        // in nginx with fcgi: fastcgi_param APP_ENV dev
        $this['env']                = getenv('APP_ENV') ? : 'prod';

        $this['request.http_port']    = 80;
        $this['request.https_port']   = 443;
        $this['debug']                = false;
        $this['charset']              = 'UTF-8';
        $this['logger']               = null;
        $this['use_cache']            = false;

        // twig
        $this['twig.cache.directory'] = "";
        $this['twig.cache_templates'] = false;

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
        $this->register(new TemplatingServiceProvider($app));

        $this['dispatcher']->addSubscriber(new RouterListener($app['matcher']));

        $this['app.extensions'] = function () use ($app) {
            $finder = new Finder();
            $directories = $finder
                ->ignoreUnreadableDirs()
                ->directories()
                ->name('*Extension')
                ->in($app['app.extensions.dir'])
                ->depth('< 3')
                ->sortByName()
            ;

            $extensions = [];
            foreach($directories as $directory) {
                $extensionName = $directory->getRelativePathname();
                $extensions[$extensionName]['name'] = $extensionName;
                $extensions[$extensionName]['pathName'] = $directory->getPathName();
            }

            $this->extensions = $extensions;

            return $extensions;
        };

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
     * Return an array of all providers loaded
     *
     * @return array
     */
    public function getProviders()
    {
        return $this->providers;
    }

    /**
     * Return an array of all extensions loaded
     *
     * @return array
     */
    public function getExtensions()
    {
        return $this->extensions;
    }
}