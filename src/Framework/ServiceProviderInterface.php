<?php

namespace Nkstamina\Framework;

use Pimple\ServiceProviderInterface as BaseServiceProviderInterface;
use Pimple\Container;

/**
 * Interface ServiceProviderInterface
 * @package Nkstamina\Framework
 */
interface ServiceProviderInterface extends BaseServiceProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function register(Container $app);

    /**
     * {@inheritdoc}
     */
    public function boot(Container $app);


    /**
     * Returns the name of the service
     *
     * @return mixed
     */
    public function getName();

} 