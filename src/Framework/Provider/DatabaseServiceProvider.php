<?php

namespace Nkstamina\Framework\Provider;
use Nkstamina\Framework\ServiceProviderInterface;
use Pimple\Container;

/**
 * Class DatabaseServiceProvider
 * @package Nkstamina\Framework\Provider
 */
class DatabaseServiceProvider implements ServiceProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function register(Container $app)
    {
        $app['db.default_options'] = array(
            'driver' => 'pdo_mysql',
            'dbname' => null,
            'host' => 'localhost',
            'user' => 'root',
            'password' => null,
            'port' => null,
        );

        $app['db'] = function () use ($app) {
            //
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
        return 'database.service.provider';
    }

} 