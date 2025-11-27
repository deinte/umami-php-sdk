<?php

namespace Deinte\UmamiSdk\Concerns;

use Deinte\UmamiSdk\Dto\LoginResult;
use Deinte\UmamiSdk\Dto\VerifiedUser;
use Deinte\UmamiSdk\Requests\Auth\LoginRequest;
use Deinte\UmamiSdk\Requests\Auth\VerifyTokenRequest;

/** @mixin \Deinte\UmamiSdk\Umami */
trait SupportsAuthenticationEndpoints
{
    /**
     * @param  array<string, mixed>  $credentials
     */
    public function login(array $credentials): LoginResult
    {
        return $this->send(new LoginRequest($credentials))->dto();
    }

    public function verifyToken(): VerifiedUser
    {
        return $this->send(new VerifyTokenRequest)->dto();
    }
}
