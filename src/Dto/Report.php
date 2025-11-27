<?php

namespace Deinte\UmamiSdk\Dto;

class Report
{
    public function __construct(
        public string $id,
        public string $userId,
        public string $websiteId,
        public string $type,
        public string $name,
        public ?string $description = null,
        public array $parameters = [],
        public ?string $createdAt = null,
        public ?string $updatedAt = null,
    ) {}

    /**
     * @param array<string, mixed> $payload
     */
    public static function fromResponse(array $payload): self
    {
        return new self(
            id: $payload['id'],
            userId: $payload['userId'],
            websiteId: $payload['websiteId'],
            type: $payload['type'],
            name: $payload['name'],
            description: $payload['description'] ?? null,
            parameters: $payload['parameters'] ?? [],
            createdAt: $payload['createdAt'] ?? null,
            updatedAt: $payload['updatedAt'] ?? null,
        );
    }
}
