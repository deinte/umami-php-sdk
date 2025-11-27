<?php

namespace Deinte\UmamiSdk\Dto;

class TeamMember
{
    public function __construct(
        public string $id,
        public string $teamId,
        public string $userId,
        public string $role,
        public ?string $createdAt = null,
        public ?string $updatedAt = null,
        public ?UserSummary $user = null,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromResponse(array $data): self
    {
        return new self(
            id: $data['id'],
            teamId: $data['teamId'],
            userId: $data['userId'],
            role: $data['role'],
            createdAt: $data['createdAt'] ?? null,
            updatedAt: $data['updatedAt'] ?? null,
            user: isset($data['user']) ? UserSummary::fromResponse($data['user']) : null,
        );
    }
}
