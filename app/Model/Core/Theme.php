<?php
namespace Nkstamina\Model\Core;

/**
 * @ORM\Entity
 */
class Theme
{

    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="Nkstamina\Model\Core\Menu", mappedBy="id")
     */
    protected $menus;

    /**
     * @ORM\OneToMany(targetEntity="Nkstamina\Model\Core\ThemeBlock", mappedBy="id")
     */
    protected $themeBlocks;

    /**
     * @ORM\Column(name="name", type="string", length=255)
     */
    protected $name;

    /**
     * @ORM\Column(name="isDefaultTheme", type="boolean")
     */
    protected $isDefaultTheme;
}