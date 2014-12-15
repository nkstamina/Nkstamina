<?php
namespace Nkstamina\Model\Extensions\Calendar;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Category
{

    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="date", type="datetime")
     */
    protected $date;

    /**
     * @ORM\Column(name="description", type="string", length=1000)
     */
    protected $description;

    /**
     * @ORM\OneToOne(targetEntity="Nkstamina\Model\Core\User", cascade={"persist"})
     */
    protected $user;

    /**
     * @ORM\Column(name="title", type="string", length=1000)
     */
    protected $title;

    /**
     * @ORM\Column(name="description", type="string", length=1000)
     */
    protected $description;
}