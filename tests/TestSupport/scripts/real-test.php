<?php

use Deinte\UmamiSdk\Umami;
use Dotenv\Dotenv;

require_once __DIR__.'/../../../vendor/autoload.php';

$dotenv = Dotenv::createImmutable(__DIR__.'/..');
$dotenv->safeLoad();

$token = $_ENV['UMAMI_API_TOKEN'] ?? '';
$baseUrl = $_ENV['UMAMI_BASE_URL'] ?? 'https://api.umami.is/v1';
$useApiKey = filter_var($_ENV['UMAMI_USE_API_KEY'] ?? true, FILTER_VALIDATE_BOOL);

$umami = new Umami($token, $baseUrl, 10, $useApiKey);

dump($umami->me());
