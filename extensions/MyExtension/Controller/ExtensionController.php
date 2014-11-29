<?php

namespace MyExtension\Controller;

class MyExtensionController
{
    public function indexAction()
    {
        return new Response('my extension', 200);
    }
} 