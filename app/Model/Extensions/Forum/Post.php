<?php
namespace Nkstamina\Model\Extensions\Forum;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="forumPost")
 */
class Post
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
     * @ORM\OneToOne(targetEntity="Nkstamina\Model\Core\User")
     */
    protected $user;

    /**
     * @ORM\Column(name="date_time", type="datetime")
     */
    protected $date_time;

    /**
     * @ORM\OneToOne(targetEntity="Nkstamina\Model\Core\User")
     */
    protected $edited_by_user;

    /**
     * @ORM\Column(name="edited_date_time", type="datetime")
     */
    protected $edited_date_time;

    /**
     * @ORM\OneToMany(targetEntity="Nkstamina\Model\Extensions\Forum\Topic", mappedBy="id")
     */
    protected $topics;
}