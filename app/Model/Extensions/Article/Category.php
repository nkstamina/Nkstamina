<?php
namespace Nkstamina\Model\Extensions\Article;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="articleCategory")
 */
class ArticleCategory
{

    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="title", type="string", length=30)
     */
    private $title;

    /**
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;
}