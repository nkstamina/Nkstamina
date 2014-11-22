<?php

namespace Nkstamina\Framework\Controller;

use Nkstamina\Framework\Application;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpKernel\Controller\ControllerResolver as BaseControllerResolver;

/**
 * Class ControllerResolver
 * @package Nkstamina\Framework\Controller
 */
class ControllerResolver extends BaseControllerResolver
{
    /**
     * @var Application
     */
    protected $app;

    /**
     * Constructor
     *
     * @param Application $app
     * @param LoggerInterface $logger
     */
    public function __construct(Application $app, LoggerInterface $logger = null)
    {
        $this->app = $app;

        parent::__construct($logger);
    }

    /**
     * {@inheritdoc}
     */
    protected function createController($controller)
    {
        if (false === strpos($controller, '::')) {
            throw new \InvalidArgumentException(sprintf('Unable to find controller "%s".', $controller));
        }

        list($class, $method) = explode('::', $controller, 2);

        if (!class_exists($class)) {
            throw new \InvalidArgumentException(sprintf('Class "%s" does not exist.', $class));
        }

        //@wip check if the class is an instance of Application or Plugins/Extensions
        $controller = new $class($this->app);

        return array($controller, $method);
    }
} 