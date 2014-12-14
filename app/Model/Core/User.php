<?php
namespace Nkstamina\Model\Core;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class User
{

    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="login", type="string", length=255)
     */
    protected $login;

    /**
     * @ORM\Column(name="password", type="string", length=255)
     */
    protected $password;

    /**
     * @ORM\OneToOne(targetEntity="Nkstamina\Model\Core\Theme", cascade={"persist"})
     */
    protected $theme;

    /**
     * @ORM\ManyToOne(targetEntity="Nkstamina\Model\Core\UserGroup")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $userGroup;
}