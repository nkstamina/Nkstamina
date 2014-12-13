<?php
namespace Nkstamina\Model\Core;

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