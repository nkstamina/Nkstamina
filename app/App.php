<?php

require_once __DIR__.'/bootstrap.php';

use Nkstamina\Framework\Application;

class App extends Application
{
    public function registerExtensions()
    {
        // Declare all your extensions here!
        $extensions = array(
            new NkStamina\MyExtension\MyExtension(),
            new NkStamina\NkStaminaExtension\NkStaminaExtension(),
        );

        return $extensions;
    }
}

// Start the application
$app = new App();

return $app;
