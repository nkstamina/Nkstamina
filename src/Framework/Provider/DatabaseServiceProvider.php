<?php

namespace Nkstamina\Framework\Provider;

use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Configuration;
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
            'driver' => '%db_driver%',
            'dbname' => null,
            'host' => 'localhost',
            'user' => 'root',
            'password' => null,
            'port' => null,
        );

        $app['db'] = function () use ($app) {
            return DriverManager::getConnection($app['db.default_options'], new Configuration());
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
        return 'database_service_provider';
    }
}

