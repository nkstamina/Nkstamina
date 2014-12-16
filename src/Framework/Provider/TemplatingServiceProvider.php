<?php

namespace Nkstamina\Framework\Provider;

use Nkstamina\Framework\ServiceProviderInterface;
use Nkstamina\Framework\Provider\Exception\InvalidTemplateDirectoryException;
use Pimple\Container;

/**
 * Class TemplatingServiceProvider
 * @package Nkstamina\Framework\Provider
 */
class TemplatingServiceProvider implements ServiceProviderInterface
{
    const EXTENSION_TEMPLATE_PATH = 'Resources/views';

    /**
     * {@inheritdoc}
     */
    public function register(Container $app)
    {
        $app['twig.path']            = array($app['app.templates.path']);
        $app['twig.templates']       = array();

        $app['twig.loader'] = function () use ($app) {
            $loaders = [];

            $twigLoaderFs = new \Twig_Loader_Filesystem($app['twig.path']);

            foreach ($app['extensions'] as $info) {

                if (!is_dir($templateViewDirectory = $info['pathName'].'/'.self::EXTENSION_TEMPLATE_PATH)) {
                    throw new InvalidTemplateDirectoryException(sprintf(
                        '"%s" is not a directory', // @wip do we have to translate this?
                        $templateViewDirectory
                    ));
                }

                $currentController = $app['request']->get('_controller');

                if (strstr($currentController, '\\', true) === $info['name']) {
                    $twigLoaderFs->addPath($templateViewDirectory);
                    break;
                }
            }

            $loaders[] = $twigLoaderFs;
            $loaders[] = new \Twig_Loader_Array($app['twig.templates']);

            return new \Twig_Loader_Chain($loaders);
        };

        $app['twig.environment'] = function () use ($app) {
            $isTemplateMustBeCached = $app['twig.cache_templates'];
            $templateCacheDirectory = $app['twig.cache.directory'];

            $options = [];
            if ($isTemplateMustBeCached &&
                $this->isTemplateCacheDirectoryValid($templateCacheDirectory)) {

                $options = ['cache' => $templateCacheDirectory];
            }

            return new \Twig_Environment($app['twig.loader'], $options);
        };

        $app['twig'] = function () use ($app) {
            return $app['twig.environment'];
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

    /**
     * Check if template cache directory is valid
     *
     * @param string $directory
     *
     * @return bool
     * @throws \Exception
     */
    private function isTemplateCacheDirectoryValid($directory)
    {
        if (!is_dir($directory) OR !is_readable($directory)) {
            throw new \Exception(sprintf(
                'Directory "%s" is not readable or does not exit', // @wip do we have to translate this?
                $directory
            ));
        }

        return true;
    }
} 
