<?php
namespace Nkstamina\Model\Core;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class ModuleRight
{

    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @ORM\OneToOne(targetEntity="Nkstamina\Model\Core\Module", cascade={"persist"})
     */
    protected $module;

    /**
     * @ORM\OneToOne(targetEntity="Nkstamina\Model\Core\UserGroup", cascade={"persist"})
     */
    protected $user_group;

    /**
     * @ORM\Column(name="main_access", type="boolean")
     */
    protected $main_access;

    /**
     * @ORM\Column(name="admin_access", type="boolean")
     */
    protected $admin_access;
}