<?php
namespace Nkstamina\Model\Core;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class MenuItem
{

    protected $menuitemId;

    protected $menuId;

    protected $blockId;

    protected $order;
}