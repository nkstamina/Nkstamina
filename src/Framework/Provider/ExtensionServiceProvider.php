<?php

namespace Nkstamina\Framework\Provider;

use Nkstamina\Framework\Common\Utils;
use Nkstamina\Framework\ServiceProviderInterface;
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
        $app['extensions.dir'] = function () use ($app) {
            $directories = $this->getExtensionsDirectories($app);
            $extensions = [];

            foreach($directories as $directory) {
                $extensionName = $directory->getRelativePathname();
                $extensions[$extensionName]['name'] = $extensionName;
                $extensions[$extensionName]['pathName'] = $directory->getPathName();
            }

            $this->extensions = $extensions;

            return $extensions;
        };


        $app['extension.parameters'] = function () use ($app) {
            // loads extension's yaml parameters
            if ($this->isConfigDirectoryValid(static::$expectedDirectories['Config'])) {
                $parameters = $this->getExtensionConfigParameters($app);


                // now override app parameters


                return $parameters;
            }
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
     * Checks if config directory exists and readable
     *
     * @param $directory
     *
     * @return bool
     */
    private function isConfigDirectoryValid($directory)
    {
        return Utils::isDirectoryValid($directory);
    }

    /**
     * Returns all valid extensions folders
     *
     * @param Container $app
     *
     * @return Finder
     */
    private function getExtensionsDirectories(Container $app)
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

    /**
     * Return config parameters for the current extension
     *
     * @param Container $app
     *
     * @return array
     */
    private function getExtensionConfigParameters(Container $app)
    {
        $parameters = [];
        $yaml = $app['config.parser'];

        $files = $app['config.finder']
            ->files()
            ->in($app['app.extensions']['']);

        foreach ($files as $file) {
            try {
                $parameters = [$yaml->parse(file_get_contents($file->getRelativePathname()))];
            } catch(ParseException $e) {
                printf("Unable to parse the YAML string: %s", $e->getMessage());
            }
        }

        return $parameters;
    }

    /**
     * Returns an array of all extensions loaded
     *
     * @return array
     */
    public function getExtensions()
    {
        return $this->extensions;
    }
} 