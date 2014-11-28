<?php

$app = require_once __DIR__.'/../app/app.php';

if ($app instanceof \Nkstamina\Framework\Application) {

    // $app->register(myServiceProvider);

    $app->run();
} else {
    echo 'Failed to initialize application.';
}
