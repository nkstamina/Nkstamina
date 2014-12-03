<?php

namespace Nkstamina\Framework\Controller;

use Nkstamina\Framework\ControllerInterface;

class Controller implements ControllerInterface
{
    protected $app;

    public function __construct($app)
    {
        $this->app = $app;
    }

    public function render()
    {

    }
}