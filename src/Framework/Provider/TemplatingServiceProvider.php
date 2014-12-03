<?php

namespace Nkstamina\Framework\Provider;

use Nkstamina\Framework\ServiceProviderInterface;
use Nkstamina\Framework\Provider\Exception\InvalidTemplateDirectoryException;
use Pimple\Container;

class TemplatingServiceProvider implements ServiceProviderInterface
{
    const TEMPLATE_DIR_NAME = 'views';

    /**
     * {@inheritdoc}
     */
    public function register(Container $app)
    {

        $app['twig.path']            = array();
        $app['twig.templates']       = array();

        $app['twig.loader'] = function () use ($app) {
            $loaders = [];

            $twigLoaderFs = new \Twig_Loader_Filesystem();
            foreach ($app['app.extensions'] as $extension => $info) {
                $templateViewDirectory = $info['pathName'] . '/' . self::TEMPLATE_DIR_NAME;

                if (!is_dir($templateViewDirectory)) {
                    throw new InvalidTemplateDirectoryException(sprintf(
                        '"%s" is not a directory', // @wip do we have to translate this?
                        $templateViewDirectory
                    ));
                }

                $twigFs->addPath($templateViewDirectory);
            }

            $loaders[] = $twigLoaderFs;
            $loaders[] = new \Twig_Loader_Array($app['twig.templates']);

            return new \Twig_Loader_Chain($loaders);
        };

        $app['twig.environment'] = function () use ($app) {
            if ($app['twig.cache_templates']) {
                if (!is_dir($app['twig.cache.directory']) OR !is_readable($app['twig.cache.directory'])) {
                    throw new \Exception(sprintf(
                        'Directory "%s" is not readable or does not exit', // @wip do we have to translate this?
                        $app['twig.cache.directory']
                    ));
                }
            }

            return new \Twig_Environment($app['twig.loader'], array(
                'cache' => $app['twig.cache.directory']
            ));
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
} 
