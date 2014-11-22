<?php

namespace Nkstamina\Framework\Provider;

use Pimple\Container;
use Nkstamina\Framework\ServiceProviderInterface;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\Matcher\UrlMatcher;

/**
 * Class RoutingServiceProvider
 * @package Nkstamina\Framework\Provider
 *
 * @see http://symfony.com/fr/doc/current/components/routing/introduction.html
 */
class RoutingServiceProvider implements ServiceProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function register(Container $app)
    {
        /**
         *  Represents a set of route instances.
         *
         * @return RouteCollection
         */
        $app['routes'] = function () use ($app) {
            return new routecollection();
        };

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
        $app['url_matcher'] = function () use ($app) {
          return new UrlMatcher($app['routes'], $app['request_context']);
        };

        /**
         * Generate a URL or a path for any route in the RouteCollection
         *
         * @return UrlGenerator
         */
        $app['url_generator'] = function () use ($app) {
            return new UrlGenerator($app['routes'], $app['request_context']);
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
        return 'routing.service.provider';
    }
}