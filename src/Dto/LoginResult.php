<?php

namespace Deinte\UmamiSdk\Dto;

class LoginResult
{
    public function __construct(
        public string $token,
        public UserSummary $user,
    ) {}

    /**
     * @param  array<string, mixed>  $payload
     */
    public static function fromResponse(array $payload): self
    {
        return new self(
            token: $payload['token'],
            user: UserSummary::fromResponse($payload['user']),
        );
    }
}
