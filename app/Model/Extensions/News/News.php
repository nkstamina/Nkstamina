<?php
namespace Nkstamina\Model\Extensions\News;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity 
 */
class News
{

    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="Nkstamina\Model\Extensions\News\Category", cascade={"persist"})
     */
    private $category;

    /**
     * @ORM\OneToOne(targetEntity="Nkstamina\Model\Core\User", cascade={"persist"})
     */    
    private $author;

    /**
     * @ORM\Column(name="text", type="string", length=255)
     */
    private $text;

    /**
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;
}