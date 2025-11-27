<?php

namespace Deinte\UmamiSdk\Dto;

class Website
{
    public function __construct(
        public string $id,
        public string $name,
        public string $domain,
        public ?string $shareId = null,
        public ?string $resetAt = null,
        public ?string $userId = null,
        public ?string $teamId = null,
        public ?string $createdBy = null,
        public ?string $createdAt = null,
        public ?string $updatedAt = null,
        public ?string $deletedAt = null,
        public ?UserSummary $user = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromResponse(array $data): self
    {
        return new self(
            id: $data['id'],
            name: $data['name'],
            domain: $data['domain'],
            shareId: $data['shareId'] ?? null,
            resetAt: $data['resetAt'] ?? null,
            userId: $data['userId'] ?? null,
            teamId: $data['teamId'] ?? null,
            createdBy: $data['createdBy'] ?? null,
            createdAt: $data['createdAt'] ?? null,
            updatedAt: $data['updatedAt'] ?? null,
            deletedAt: $data['deletedAt'] ?? null,
            user: isset($data['user']) ? UserSummary::fromResponse($data['user']) : null,
        );
    }

    /**
     * @param array<int, array<string, mixed>> $items
     * @return array<int, self>
     */
    public static function collect(array $items): array
    {
        return array_map(fn (array $item) => self::fromResponse($item), $items);
    }
}
