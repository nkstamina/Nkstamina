<?php
namespace Nkstamina\Model\Core;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="coreModuleRight")
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
     * @ORM\Column(name="mainAccess", type="boolean")
     */
    protected $main_access;

    /**
     * @ORM\Column(name="adminAccess", type="boolean")
     */
    protected $admin_access;
}