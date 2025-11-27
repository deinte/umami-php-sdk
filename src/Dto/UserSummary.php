<?php

namespace Deinte\UmamiSdk\Dto;

class UserSummary
{
    public function __construct(
        public string $id,
        public string $username,
        public ?string $role = null,
        public ?string $createdAt = null,
        public ?bool $isAdmin = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromResponse(array $data): self
    {
        return new self(
            id: $data['id'],
            username: $data['username'],
            role: $data['role'] ?? null,
            createdAt: $data['createdAt'] ?? null,
            isAdmin: $data['isAdmin'] ?? null,
        );
    }
}
