<?php

namespace Nkstamina\Framework\Provider;

use Nkstamina\Framework\ServiceProviderInterface;
use Pimple\Container;

class TemplatingServiceProvider implements ServiceProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function register(Container $app)
    {
        // TODO: Implement register() method.
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