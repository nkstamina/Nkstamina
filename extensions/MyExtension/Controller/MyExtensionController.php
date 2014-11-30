<?php

namespace MyExtension\Controller;

use Symfony\Component\HttpFoundation\Response;

class MyExtensionController
{
    public function indexAction($name)
    {
        return new Response($name, 200);
    }
} 