<?php

namespace Nkstamina\Framework\Controller;

use Nkstamina\Framework\ControllerInterface;

class Controller implements ControllerInterface
{
    private $app;

    public function __construct($app)
    {
        $this->app = $app;
    }

    public function render()
    {

    }
}