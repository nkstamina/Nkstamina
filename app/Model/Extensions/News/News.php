<?php
namespace Nkstamina\Model\Extensions\News;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="forumNews") 
 */
class News
{

    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToOne(targetEntity="Nkstamina\Model\Extensions\News\NewsCategory", cascade={"persist"})
     */
    protected $category;

    /**
     * @ORM\OneToOne(targetEntity="Nkstamina\Model\Core\User", cascade={"persist"})
     */
    protected $author;

    /**
     * @ORM\Column(name="text", type="string", length=255)
     */
    protected $text;

    /**
     * @ORM\Column(name="date", type="datetime")
     */
    protected $date;
}