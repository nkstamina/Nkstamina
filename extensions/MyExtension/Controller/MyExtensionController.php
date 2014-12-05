<?php

namespace MyExtension\Controller;

use Symfony\Component\HttpFoundation\Request;
use Nkstamina\Framework\Controller\Controller as FrameworkController;
use Symfony\Component\HttpFoundation\Response;

class MyExtensionController extends FrameworkController
{
    public function indexAction($name)
    {
        return $this->render('index.html.twig');
    }
} 