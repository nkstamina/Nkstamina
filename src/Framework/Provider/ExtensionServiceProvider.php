<?php

namespace Nkstamina\Framework\Provider;

use Nkstamina\Framework\ServiceProviderInterface;
use Pimple\Container;
use Symfony\Component\Finder\Finder;

/**
 * Class ExtensionServiceProvider
 * @package Nkstamina\Framework\Provider
 */
class ExtensionServiceProvider implements ServiceProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function register(Container $app)
    {
        // load extensions
        $this['app.extensions'] = function () use ($app) {
            $finder = new Finder();
            $directories = $finder
                ->ignoreUnreadableDirs()
                ->directories()
                ->name('*Extension')
                ->in($app['app.extensions.dir'])
                ->depth('< 3')
                ->sortByName()
            ;

            $extensions = [];
            foreach($directories as $directory) {
                $extensionName = $directory->getRelativePathname();
                $extensions[$extensionName]['name'] = $extensionName;
                $extensions[$extensionName]['pathName'] = $directory->getPathName();
            }

            $this->extensions = $extensions;

            return $extensions;
        };
    }

    /**
     * {@inheritdoc}
     */
    public function boot(Container $app)
    {
        // TODO: Implement boot() method.
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'templating_service_provider';
    }

} 