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
    const CONFIG_DIRECTORY = 'config';

    /**
     * {@inheritdoc}
     */
    public function register(Container $app)
    {
        echo dirname(dirname(__FILE__));
        exit;
        $path =  realpath(dirname(__DIR__) . '/../../../') . '/' . self::APP_DIRECTORY . '/' . self::CONFIG_DIRECTORY;
        $configDirectories = [$path];
        $locator = new FileLocator($configDirectories);

        $app['config_loader'] = function () use ($app, $locator) {
            // load only *.yml files?
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