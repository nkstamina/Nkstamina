<?php
namespace Nkstamina\Model\Extensions\Forum;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="OC\PlatformBundle\Entity\ImageRepository")
 * @ORM\Table(name="forumUserTopicSeen")
 */
class UserTopicSeen
{

    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="Nkstamina\Model\Extensions\Forum\Topic")
     */
    private $topic;

    /**
     * @ORM\OneToOne(targetEntity="Nkstamina\Model\Core\User")
     */
    private $user;

    /**
     * @ORM\Column(name="lastSeen", type="datetime")
     */
    private $last_seen;
}