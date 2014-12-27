<?php

namespace Nkstamina\Core\Controller;

use Nkstamina\Framework\Controller\Controller as FrameworkController;
use Nkstamina\Model\Core\MenuItem;

class MenuController extends FrameworkController
{

    public function menuAction()
    {
        // Déclaration en dur temporaire du menu
        $menu_item_1 = new MenuItem();
        $menu_item_1->setLink("/index.php");
        $menu_item_1->setText("Accueil");
        $menu_item_2 = new MenuItem();
        $menu_item_2->setLink("/extension/test");
        $menu_item_2->setText("Extension");
        $menu_list = new array($menu_item_1, $menu_item_2);

        return $this->render("menu.html.twig", array(
           "menuList" => $menu_list
        ));

    }
}

