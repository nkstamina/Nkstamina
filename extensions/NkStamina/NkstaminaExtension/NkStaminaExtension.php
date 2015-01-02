<?php
namespace Nkstamina\NkstaminaExtension;

use Nkstamina\Framework\Application;
use Nkstamina\Framework\Extension\Extension;


class NkStaminaExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $config, Application $app)
    {
        $loader = $app['config.loader'];
    }
}