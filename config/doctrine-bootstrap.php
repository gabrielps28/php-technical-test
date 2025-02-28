<?php
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;

require_once __DIR__ . '../../vendor/autoload.php';

$entityPath = realpath(__DIR__ . '/../src/Domain/User/Entity');
if ($entityPath === false) {
    throw new \RuntimeException('The entities directory path is incorrect: ' . __DIR__ . '/../src/Domain/User/Entity');
}

$config = ORMSetup::createAttributeMetadataConfiguration(
    paths: [$entityPath], 
    isDevMode: true,
);

$connectionParams = [
    'driver'   => 'pdo_mysql',
    'user'     => 'root',
    'password' => 'root',
    'dbname'   => 'app_db',
    'host'     => 'mysql',
];


$connection = DriverManager::getConnection($connectionParams, $config);

$entityManager = new EntityManager($connection, $config);
return $entityManager;