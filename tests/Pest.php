<?php

use Deinte\UmamiSdk\Umami;
use Dotenv\Dotenv;
use Saloon\Http\Faking\MockClient;

uses()->in(__DIR__);

function umamiMock(): Umami
{
    MockClient::destroyGlobal();

    $dotenv = Dotenv::createImmutable(__DIR__.'/TestSupport');
    $dotenv->safeLoad();

    $token = $_ENV['UMAMI_API_TOKEN'] ?? 'fake-token';
    $baseUrl = $_ENV['UMAMI_BASE_URL'] ?? 'https://api.umami.is/v1';
    $useApiKey = filter_var($_ENV['UMAMI_USE_API_KEY'] ?? true, FILTER_VALIDATE_BOOL);

    return new Umami($token, $baseUrl, 10, $useApiKey);
}

function markTestComplete(): void
{
    expect(true)->toBeTrue();
}
