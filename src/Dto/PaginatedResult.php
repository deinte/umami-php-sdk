<?php

namespace Deinte\UmamiSdk\Dto;

/**
 * @template T
 *
 * @implements \IteratorAggregate<int, T>
 */
class PaginatedResult implements \IteratorAggregate
{
    /**
     * @param  array<int, T>  $items
     */
    public function __construct(
        public array $items,
        public int $count,
        public int $page,
        public int $pageSize,
        public ?string $orderBy = null,
    ) {}

    /**
     * @template U
     *
     * @param  array<string, mixed>  $payload
     * @param  callable(array<string, mixed>): U  $mapper
     * @return self<U>
     */
    public static function fromResponse(array $payload, callable $mapper): self
    {
        $items = array_map($mapper, $payload['data'] ?? []);

        return new self(
            items: $items,
            count: (int) ($payload['count'] ?? 0),
            page: (int) ($payload['page'] ?? 1),
            pageSize: (int) ($payload['pageSize'] ?? count($items)),
            orderBy: $payload['orderBy'] ?? null,
        );
    }

    /**
     * @return \ArrayIterator<int, T>
     */
    public function getIterator(): \ArrayIterator
    {
        return new \ArrayIterator($this->items);
    }
}
