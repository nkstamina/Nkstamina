<?php

namespace Nkstamina\Framework;

use Nkstamina\Framework\Common\Utils;
use Nkstamina\Framework\Controller\ControllerResolver;
use Nkstamina\Framework\Provider\ConfigServiceProvider;
use Nkstamina\Framework\Provider\RoutingServiceProvider;
use Nkstamina\Framework\Provider\TemplatingServiceProvider;
use Nkstamina\Framework\Provider\ExtensionServiceProvider;
use Pimple\ServiceProviderInterface;
use Pimple\Container;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\EventListener\RouterListener;
use Symfony\Component\HttpKernel\HttpKernel;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Parser;
use Symfony\Component\Yaml\Yaml;

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

        $this['app.root.dir']       = realpath(__DIR__ . '/../../../../../');
        $this['app.extensions.dir'] = $app['app.root.dir'].'/extensions';
        $this['app.dir']            = $app['app.root.dir'].'/app';
        $this['app.config.dir']     = $app['app.dir'].'/config';
        $this['app.cache.dir']      = $app['app.dir'].'/cache';

        // twig
        $this['app.templates.path']   = $app['app.dir'].'/Resources/views';
        $this['twig.cache.directory'] = $this['app.cache.dir'].'/templates';
        $this['twig.cache_templates'] = false;

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

        $this['request_error'] = $this->protect(function () {
            throw new \RuntimeException('Accessed request service outside of request scope. Try moving that call to a before handler or controller.');
        });
        $this['request'] = $this['request_error'];

        $this->register(new ConfigServiceProvider($app));
        $this->register(new RoutingServiceProvider($app));
        $this->register(new TemplatingServiceProvider($app));
        $this->register(new ExtensionServiceProvider($app));

        // loads App configuration parameters
        $this['app.parameters'] = $app->factory(function () use ($app) {
            $parameters = [];

            if (Utils::isDirectoryValid($app['app.config.dir'])) {
                $files = $app['config.finder']
                    ->files()
                    ->name('*.yml')
                    ->in($app['app.config.dir'])
                    ->in($app['app.extensions.dir'])
                ;

                $yaml = $app['config.parser'];

                foreach($files as $file) {
                    try {
                        $parameters[$file->getRelativePathname()] = [$yaml->parse(file_get_contents($file->getRealpath()))];

                    } catch(ParseException $e) {
                        printf("Unable to parse the YAML string: %s", $e->getMessage());
                    }
                }
            }

            return $parameters;
        });


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

        $current = HttpKernelInterface::SUB_REQUEST === $type ? $this['request'] : $this['request_error'];

        $this['request'] = $request;

        $request->attributes->add($this['matcher']->match($request->getPathInfo()));

        $response =  $this['kernel']->handle($request, $type, $catch);

        $this['request'] = $current;

        return $response;
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
     * Returns an array of all providers loaded
     *
     * @return array
     */
    public function getProviders()
    {
        return $this->providers;
    }

    /**
     * Sets a value for a key
     *
     * @param $key
     * @param $value
     */
    public function setValue($key, $value)
    {
        $this[$key] = $value;
    }

    /**
     * Returns a specific value for a key
     *
     * @param $key
     *
     * @return mixed
     */
    public function getValue($key)
    {
        return $this[$key];
    }
}
