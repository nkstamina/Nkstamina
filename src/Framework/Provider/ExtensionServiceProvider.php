<?php

namespace Nkstamina\Framework\Provider;

use Nkstamina\Framework\Common\Utils;
use Nkstamina\Framework\ServiceProviderInterface;
use Nkstamina\Framework\Provider\Exception\InvalidConfigurationException;
use Pimple\Container;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Yaml;

/**
 * Class ExtensionServiceProvider
 * @package Nkstamina\Framework\Provider
 */
class ExtensionServiceProvider implements ServiceProviderInterface
{
    protected static $expectedDirectories = ['Config, Controller, Model, Resources, Views'];
    protected $extensions = [];

    /**
     * {@inheritdoc}
     */
    public function register(Container $app)
    {
        $app['extensions'] = function () use ($app) {
            // Get extensions directories
            return $this->getExtensions($app);
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
        return 'extension_service_provider';
    }

    /**
     * Return an array of extensions
     *
     * @param Container $app
     *
     * @return array
     */
    public function getExtensions(Container $app)
    {
        $directories = $this->findExtensionsDirectories($app);

        foreach ($directories as $directory) {
            $extensionName                                  = $directory->getRelativePathname();
            $this->extensions[$extensionName]['name']       = $extensionName;
            $this->extensions[$extensionName]['pathName']   = $directory->getPathName();
        }

        return $this->extensions;
    }

    /**
     * Returns all valid extensions folders
     *
     * @param Container $app
     *
     * @return Finder
     */
    private function findExtensionsDirectories(Container $app)
    {
        $directories = $app['config.finder']
            ->ignoreUnreadableDirs()
            ->directories()
            ->name('*Extension')
            ->in($app['app.extensions.dir'])
            ->depth('< 3')
            ->sortByName()
        ;

        return $directories;
    }
}

