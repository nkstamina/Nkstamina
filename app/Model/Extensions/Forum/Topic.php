<?php
namespace Nkstamina\Model\Extensions\Forum;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Topic
{

    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToOne(targetEntity="Nkstamina\Model\Extensions\Forum\Forum")
     */
    protected $forum;

    /**
     * @ORM\Column(name="title", type="string", length=255)
     */
    protected $title;

    /**
     * @ORM\Column(name="description", type="string", length=1000)
     */
    protected $description;

    /**
     * @ORM\OneToOne(targetEntity="Nkstamina\Model\Core\User")
     */
    protected $user;

    /**
     * @ORM\Column(name="date_time", type="datetime", length=1000)
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
     * @ORM\Column(name="last_post_date", type="datetime")
     */
    protected $last_post_date;
}