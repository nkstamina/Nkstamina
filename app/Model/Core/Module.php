<?php
namespace Nkstamina\Model\Core;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Module
{

    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
}