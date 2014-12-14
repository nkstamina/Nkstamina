<?php
namespace Nkstamina\Model\Extensions\Article;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Article
{

    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity="Nkstamina\Model\Extensions\Article", mappedBy="id")
     */
    private $category;

    /**
     * @ORM\OneToMany(targetEntity="Nkstamina\Model\Core\User", mappedBy="id")
     */
    private $user;

    /**
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(name="text", type="string", length=1000)
     */
    private $text;

    /**
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;
}