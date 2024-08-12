<?php

declare(strict_types=1);

use vBulletin\Logger;
use vBulletin\Render;
use vBulletin\Search\SearchRepository;
use vBulletin\Search\SearchRequest;
use vBulletin\Search\SearchService;

require '../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$dbHost = getenv('DB_HOST');
$dbName = getenv('DB_NAME');
$dbUser = getenv('DB_USER');
$dbPassword = getenv('DB_PASS');

$db = new PDO("mysql:dbname={$dbName};host={$dbHost}", $dbUser, $dbPassword);
$logger = new Logger(getenv('LOG_FILE'));
$repository = new SearchRepository($db);
$searchService = new SearchService($repository, new Render(), $logger);

$request = new SearchRequest((int)$_REQUEST['searchID'] ?? null, $_REQUEST['query'] ?? null);
$searchService->search($request);


