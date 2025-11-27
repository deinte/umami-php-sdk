<?php

namespace Deinte\UmamiSdk\Dto;

class SessionContext
{
    public function __construct(
        public string $token,
        public string $authKey,
        public ?string $shareToken,
        public UserSummary $user,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromResponse(array $data): self
    {
        return new self(
            token: $data['token'],
            authKey: $data['authKey'],
            shareToken: $data['shareToken'] ?? null,
            user: UserSummary::fromResponse($data['user']),
        );
    }
}
