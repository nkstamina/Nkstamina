<?php
namespace Nkstamina\Model\Core;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="coreMenuItem") 
 */
class MenuItem
{

    protected $menuitemId;

    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToOne(targetEntity="Nkstamina\Model\Core\Block", cascade={"persist"})
     */
    protected $block;

    /**
     * @ORM\Column(name="order", type="integer")
     */
    protected $order;
}