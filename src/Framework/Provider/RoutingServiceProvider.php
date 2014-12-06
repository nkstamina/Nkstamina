<?php

namespace Nkstamina\Framework\Provider;

use Pimple\Container;
use Nkstamina\Framework\ServiceProviderInterface;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\Router;
use Symfony\Component\Routing\Matcher\RedirectableUrlMatcher;

/**
 * Class RoutingServiceProvider
 * @package Nkstamina\Framework\Provider
 *
 * @see http://symfony.com/doc/current/components/routing/introduction.html
 */
class RoutingServiceProvider implements ServiceProviderInterface
{
    const CACHE_DIRECTORY = 'cache';
    const CONFIG_ROUTES_FILE = 'routing.yml';

    /**
     * {@inheritdoc}
     */
    public function register(Container $app)
    {
        /**
         * Holds information about the current request
         *
         * @return RequestContext
         */
        $app['request_context'] = function () use ($app) {
            $context = new RequestContext();

            // set default http & https ports if not set
            $context->setHttpPort(isset($app['request.http_port']) ? $app['request.http_port'] : 80);
            $context->setHttpsPort(isset($app['request.https_port']) ? $app['request.https_port'] : 443);

            return $context;
        };

        /**
         * Matches URL based on a set of routes.
         *
         * @return UrlMatcher
         */
        $app['matcher'] = function () use ($app) {
          return new UrlMatcher($app['router'], $app['request_context']);
        };

        /**
         * Router
         */
        $options = array(
            'cache_dir' => true === $app['use_cache']
                    ? __DIR__ . '/' . self::CACHE_DIRECTORY
                    : null,
            'debug' => true
        );

        $app['router'] = function () use ($app, $options) {
             $router = new Router(
                $app['config.loader'],
                sprintf(self::CONFIG_ROUTES_FILE, $app['env']),
                $options
            );

            return $router->getRouteCollection();
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
        return 'routing_service_provider';
    }
}