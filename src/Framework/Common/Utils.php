<?php

namespace Nkstamina\Framework\Common;

/**
 * Class Utils
 * @package Nkstamina\Framework\Common
 */
class Utils
{
    /**
     * Checks if a directory is valid
     *
     * @param string $directory
     *
     * @return bool
     * @throws \Exception
     */
    public static function isDirectoryValid($directory)
    {
        if (!is_dir($directory) OR !is_readable($directory)) {
            throw new \Exception(sprintf(
                'Directory "%s" is not readable or does not exit', // @wip do we have to translate this?
                $directory
            ));
        }

        return true;
    }
} 