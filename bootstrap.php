<?php
require __DIR__ . '/vendor/autoload.php';
use Src\System\DatabaseConnector;

$dotenv = new Dotenv\Dotenv(__DIR__);
$dotenv->load();

// test code, should output:
// api://default
// when you run $ php bootstrap.php
echo getenv('OKTAAUDIENCE');

$dbConnection = (new DatabaseConnector())->getConnection();
