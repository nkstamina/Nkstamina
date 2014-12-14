<?php
namespace Nkstamina\Model\Extensions\Forum;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="OC\PlatformBundle\Entity\ImageRepository")
 */
class UserTopicSeen
{

    private $topicId;

    private $userId;

    private $lastSeen;
}