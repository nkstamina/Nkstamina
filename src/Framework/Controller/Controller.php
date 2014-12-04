<?php

namespace Nkstamina\Framework\Controller;

use Nkstamina\Framework\Application;
use Nkstamina\Framework\ControllerInterface;
use Symfony\Component\HttpFoundation\Response;

class Controller implements ControllerInterface
{
    /**
     * @var Application
     */
    protected $app;

    /**
     * Constructor
     *
     * @param $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * {@inheritdoc}
     */
    public function render($name, array $value = [])
    {
        return new Response($this->app['twig']->render($name, $value));
    }
}
