<?php
namespace Nkstamina\Model\Extensions\News;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class News
{

    private $id;

    private $category;

    private $author;

    private $text;

    private $date;
}