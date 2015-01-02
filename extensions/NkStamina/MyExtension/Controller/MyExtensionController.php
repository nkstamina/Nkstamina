<?php
namespace NkStamina\MyExtension\Controller;

use Symfony\Component\HttpFoundation\Request;
use Nkstamina\Framework\Controller\Controller as FrameworkController;
use Symfony\Component\HttpFoundation\Response;

class MyExtensionController extends FrameworkController
{
    /**
     * Test controller
     *
     * @param strint $qs    query string
     * @return mixed|Response
     */
    public function indexAction($qs)
    {
        return $this->render('index.html.twig', array(
            'qs' => $qs
        ));
    }
} 