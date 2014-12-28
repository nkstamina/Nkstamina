<?php
namespace NkstaminaExtension;

use Nkstamina\Framework\Application;
use Nkstamina\Framework\Extension\Extension as BaseExtension;


class NkStaminaExtension extends BaseExtension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $config, Application $app)
    {
        $loader = $app['config.loader'];
    }
}