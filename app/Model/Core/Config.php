<?php
namespace Nkstamina\Model\Core;

/**
 * Class Config
 *
 * @package Nkstamina\Model\Core
 */
class Config
{

    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="key", type="string", length=255)
     */
    protected $key;

    /**
     * @ORM\Column(name="value", type="string", length=255)
     */
    protected $value;
}