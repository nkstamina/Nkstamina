<?php

namespace Nkstamina\Controller;

use Nkstamina\Framework\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class MainController extends Controller
{
    public function homepageAction()
    {
        return new Response('aaa', 200);
    }
}