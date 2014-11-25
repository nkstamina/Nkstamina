<?php

namespace Nkstamina\Framework\Provider;

use Nkstamina\Framework\ServiceProviderInterface;
use Pimple\Container;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Routing\Loader\YamlFileLoader;

/**
 * Class ConfigServiceProvider
 * @package Nkstamina\Framework\Provider
 */
class ConfigServiceProvider implements ServiceProviderInterface
{
    const APP_DIRECTORY    = 'app';
    const CACHE_DIRECTORY  = 'cache';
    const CONFIG_DIRECTORY = 'config';
    const CONFIG_ROUTES_FILE = 'routes.yml';

    /**
     * {@inheritdoc}
     */
    public function register(Container $app)
    {
        $configDirectories = [self::APP_DIRECTORY . '/' . self::CONFIG_DIRECTORY];
        $locator = new FileLocator($configDirectories);

        // load only *.yml files?
        $app['config_loader'] = function () use ($locator) {
            $loader =  new YamlFileLoader($locator);

            return $loader;
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