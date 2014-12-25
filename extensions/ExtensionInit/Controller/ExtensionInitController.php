<?php
namespace ExtensionInit\Controller;

use Symfony\Component\HttpFoundation\Request;
use Nkstamina\Framework\Controller\Controller as FrameworkController;
use Symfony\Component\HttpFoundation\Response;

class ExtensionInitController extends FrameworkController
{

    public function indexAction()
    {
        $doctrine = $this->getDoctrine();
        return $this->render('init.html.twig');
    }
} 