<?php

use Deinte\UmamiSdk\Requests\Auth\LoginRequest;
use Deinte\UmamiSdk\Requests\Auth\VerifyTokenRequest;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

beforeEach(function () {
    $this->umami = umamiMock();
});

it('logs in and verifies token', function () {
    MockClient::global([
        LoginRequest::class => MockResponse::fixture('auth/login'),
        VerifyTokenRequest::class => MockResponse::fixture('auth/verify'),
    ]);

    $login = $this->umami->login([
        'username' => 'admin',
        'password' => 'secret',
    ]);

    $verified = $this->umami->verifyToken();

    expect($login->token)->toBe('login-token')
        ->and($verified->teams)->toHaveCount(1);
});
