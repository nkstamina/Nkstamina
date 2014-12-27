<?php

namespace Nkstamina\Framework\Provider;

use Nkstamina\Framework\ServiceProviderInterface;
use Pimple\Container;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Routing\Loader\YamlFileLoader;
use Symfony\Component\Yaml\Parser;

/**
 * Class ConfigServiceProvider
 * @package Nkstamina\Framework\Provider
 */
class ConfigServiceProvider implements ServiceProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function register(Container $app)
    {
        $configDirectories = [$app['app.config.dir']];
        $locator = new FileLocator($configDirectories);

        // Loads routes files
        $app['config.loader'] = function ($app) use ($locator) {
            // load only *.yml files?
            $loader =  new YamlFileLoader($locator);
            return $loader;
        };

        // Finds files or directories
        $app['config.finder'] = function () {
            return new Finder();
        };

        // Parses yaml files
        $app['config.parser'] = function () {
            return new Parser();
        };
    }

    /**
     * {@inheritdoc}
     */
    public function boot(Container $app)
    {
    }

    /**
     * Returns the name of the service
     *
     * @return mixed
     */
    public function getName()
    {
        return 'config_service_provider';
    }
}
