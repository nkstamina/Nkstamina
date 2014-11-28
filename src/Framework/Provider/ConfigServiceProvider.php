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

    // to switch between prod & dev
    // just set the APP_ENV environment variable:
    // in apache: SetEnv APP_ENV dev
    // in nginx with fcgi: fastcgi_param APP_ENV dev
    const CONFIG_ROUTES_FILE = 'routing.yml';

    /**
     * {@inheritdoc}
     */
    public function register(Container $app)
    {
        $app['root_dir'] = realpath(__DIR__ . '/../../../../');
        $configDirectories = [ $app['root_dir'] . '/' . self::APP_DIRECTORY . '/' . self::CONFIG_DIRECTORY];

//        print_r($configDirectories);
//        exit;
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