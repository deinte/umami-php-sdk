<?php

namespace Deinte\UmamiSdk\Dto;

class Link
{
    public function __construct(
        public string $id,
        public string $name,
        public string $url,
        public string $slug,
        public ?string $userId = null,
        public ?string $teamId = null,
        public ?string $createdAt = null,
        public ?string $updatedAt = null,
        public ?string $deletedAt = null,
    ) {}

    /**
     * @param  array<string, mixed>  $payload
     */
    public static function fromResponse(array $payload): self
    {
        return new self(
            id: $payload['id'],
            name: $payload['name'],
            url: $payload['url'],
            slug: $payload['slug'],
            userId: $payload['userId'] ?? null,
            teamId: $payload['teamId'] ?? null,
            createdAt: $payload['createdAt'] ?? null,
            updatedAt: $payload['updatedAt'] ?? null,
            deletedAt: $payload['deletedAt'] ?? null,
        );
    }
}
