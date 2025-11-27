<?php

namespace Deinte\UmamiSdk\Dto;

class Team
{
    /**
     * @param  array<int, TeamMember>  $members
     * @param  array<string, int>  $counts
     */
    public function __construct(
        public string $id,
        public string $name,
        public ?string $accessCode = null,
        public ?string $logoUrl = null,
        public ?string $createdAt = null,
        public ?string $updatedAt = null,
        public ?string $deletedAt = null,
        public array $members = [],
        public array $counts = [],
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromResponse(array $data): self
    {
        $members = array_map(
            fn (array $member) => TeamMember::fromResponse($member),
            $data['members'] ?? [],
        );

        return new self(
            id: $data['id'],
            name: $data['name'],
            accessCode: $data['accessCode'] ?? null,
            logoUrl: $data['logoUrl'] ?? null,
            createdAt: $data['createdAt'] ?? null,
            updatedAt: $data['updatedAt'] ?? null,
            deletedAt: $data['deletedAt'] ?? null,
            members: $members,
            counts: $data['_count'] ?? [],
        );
    }
}
