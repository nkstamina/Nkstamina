<?php
namespace Nkstamina\Model\Core;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class ModuleRight
{

    protected $moduleId;

    protected $userGroupId;

    protected $mainAccess;

    protected $adminAccess;
}