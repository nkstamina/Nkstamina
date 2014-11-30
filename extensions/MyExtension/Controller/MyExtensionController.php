<?php

namespace MyExtension\Controller;

use Symfony\Component\HttpFoundation\Response;
use Nkstamina\Framework\Controller\Controller as BaseController;

class MyExtensionController extends BaseController
{
    public function indexAction($name)
    {
        return new Response($name, 200);
    }
} 