<?php

namespace NkstaminaExtension\Controller;

use Nkstamina\Framework\Controller\Controller as FrameworkController;
use Symfony\Component\HttpFoundation\Request;

class MainController extends FrameworkController
{
    public function homepageAction(Request $request)
    {
        return $this->render('index.html.twig', array('name' => 'John Doe'));
    }
}