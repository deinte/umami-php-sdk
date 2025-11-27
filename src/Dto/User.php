<?php

namespace Deinte\UmamiSdk\Dto;

class User
{
    public function __construct(
        public string $id,
        public string $username,
        public string $role,
        public ?string $logoUrl = null,
        public ?string $displayName = null,
        public ?string $createdAt = null,
        public ?string $updatedAt = null,
        public ?string $deletedAt = null,
        public array $counts = [],
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromResponse(array $data): self
    {
        return new self(
            id: $data['id'],
            username: $data['username'],
            role: $data['role'],
            logoUrl: $data['logoUrl'] ?? null,
            displayName: $data['displayName'] ?? null,
            createdAt: $data['createdAt'] ?? null,
            updatedAt: $data['updatedAt'] ?? null,
            deletedAt: $data['deletedAt'] ?? null,
            counts: $data['_count'] ?? [],
        );
    }

    /**
     * @param  array<int, array<string, mixed>>  $items
     * @return array<int, self>
     */
    public static function collect(array $items): array
    {
        return array_map(fn (array $item) => self::fromResponse($item), $items);
    }
}
