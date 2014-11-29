<?php

$app = require_once __DIR__.'/../app/app.php';

//if (!in_array(@$_SERVER['REMOTE_ADDR'], array('127.0.0.1', '::1'))) {
//    die('You are not allowed to access this file. Check '.basename(__FILE__).' for more information.');
//}


if ($app instanceof \Nkstamina\Framework\Application) {

    $app->run();

} else {
    echo 'Failed to initialize application.';
}
