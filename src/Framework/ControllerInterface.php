<?php

namespace Nkstamina\Framework;

interface ControllerInterface
{
    /**
     * Renders a template
     *
     * @param       $name
     * @param array $value
     *
     * @return mixed
     */
    public function render($name, array $value = []);
} 