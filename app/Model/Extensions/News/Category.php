<?php
namespace Nkstamina\Model\Extensions\News;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="newsCategory")
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
     * @ORM\Column(name="title", type="string", length=255)
     */
    protected $title;

    /**
     * @ORM\Column(name="description", type="string", length=255)
     */
    protected $description;

    /**
     * @ORM\Column(name="picture", type="string", length=255)
     */
    protected $picture;
}
