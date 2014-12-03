<?php

namespace Nkstamina\Framework\Provider;

use Nkstamina\Framework\ServiceProviderInterface;
use Pimple\Container;

class TemplatingServiceProvider implements ServiceProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function register(Container $app)
    {
        $app['twig.cache.directory'] = "";
        $app['twig.path']            = array();
        $app['twig.templates']       = array();

        $app['twig.loader.filesystem'] = function () use ($app) {
            return new \Twig_Loader_Filesystem($app['twig.path']);
        };

        $app['twig.loader.array'] = function () use ($app) {
            return new \Twig_Loader_Array($app['twig.templates']);
        };

        $app['twig.environment'] = function () use ($app) {
            return new \Twig_Environment($app['twig.loader'], array(
                'cache' => $app['twig.cache.directory']
            ));
        };

        $app['twig.loader'] = function () use ($app) {
            new \Twig_Loader_Chain(array(
                $app['twig.loader.filesystem'],
                $app['twig.loader.array']
            ));
        };

        $app['twig'] = function () use ($app) {
            return new \Twig_Environment($app['twig.environment']);
        };
    }

    /**
     * {@inheritdoc}
     */
    public function boot(Container $app)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'templating_service_provider';
    }
} 