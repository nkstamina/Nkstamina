<?php

namespace Nkstamina\Controller;

use Symfony\Component\HttpFoundation\Response;

class MainController
{
    public function homepageAction()
    {
        return new Response('aaa', 200);
    }
}