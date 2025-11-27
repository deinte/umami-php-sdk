<?php

namespace Deinte\UmamiSdk\Dto;

class VerifiedUser extends UserSummary
{
    /**
     * @param array<int, Team> $teams
     */
    public function __construct(
        string $id,
        string $username,
        ?string $role = null,
        ?string $createdAt = null,
        ?bool $isAdmin = null,
        public array $teams = [],
    ) {
        parent::__construct($id, $username, $role, $createdAt, $isAdmin);
    }

    /**
     * @param array<string, mixed> $payload
     */
    public static function fromResponse(array $payload): self
    {
        return new self(
            id: $payload['id'],
            username: $payload['username'],
            role: $payload['role'] ?? null,
            createdAt: $payload['createdAt'] ?? null,
            isAdmin: $payload['isAdmin'] ?? null,
            teams: array_map(
                fn (array $team) => Team::fromResponse($team),
                $payload['teams'] ?? [],
            ),
        );
    }
}
