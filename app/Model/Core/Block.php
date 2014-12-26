<?php
namespace Nkstamina\Model\Core;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="coreBlock")
 */
class Block
{

    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToOne(targetEntity="Nkstamina\Model\Core\Extension", cascade={"persist"})
     */
    protected $extension;

    /**
     * @ORM\Column(name="name", type="string", length=255)
     */
    protected $name;
}