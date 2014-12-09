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
            $this->extensions[$extensionName]['parameters'] = $this->findExtensionParameters($app, $directory);
        }

        return $this->extensions;
    }

    /**
     * Returns all parameters related to an extension
     *
     * @param $extensionName
     *
     * @return mixed
     */
    public function getExtensionParameters($extensionName)
    {
        return $this->extensions[$extensionName]['parameters'];
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

    /**
     * Return config parameters for the current extension
     *
     * @param Container $app
     * @param           $directory
     *
     * @throws Exception\InvalidConfigurationException
     *
     * @return array
     */
    private function findExtensionParameters(Container $app, $directory)
    {
        $parameters = [];
        $yaml = $app['config.parser'];

        $files = $app['config.finder']
            ->files()
            ->name('*.yml')
            ->in($directory->getPathName())
        ;

        foreach ($files as $file) {

            try {
                $parameters[$file->getRelativePathname()] = [$yaml->parse(file_get_contents($file->getPathName()))];

            } catch(ParseException $e) {
                printf("Unable to parse the YAML string: %s", $e->getMessage());
            }

            // @wip do we have to translate this?
            /*if (!isset($parameters[$file->getRelativePathname()][0]['parameters'])) {
                throw new InvalidConfigurationException(sprintf('The key "parameters" must be defined in your file %s', $file->getPathName()));
            }*/
        }

        return $parameters;
    }
} 