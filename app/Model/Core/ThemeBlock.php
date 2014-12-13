<?php
namespace Nkstamina\Model\Core;

/**
 * @ORM\Entity
 */
class ThemeBlock
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="order", type="integer")
     */   
    protected $order;
}