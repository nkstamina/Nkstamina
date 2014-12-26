<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

// commandes temporaires avant l'intégration complète de Doctrine dans le framework ->
$paths = array(
    __DIR__ . "/Model"
);
$is_dev_mode = true;

// the connection configuration
$db_params = array(
    'driver' => 'pdo_mysql',
    'user' => 'root',
    'password' => '',
    'dbname' => 'nkstamina'
);

$config = Setup::createAnnotationMetadataConfiguration($paths, $is_dev_mode, null, null, false);
$em = EntityManager::create($db_params, $config);
// <-