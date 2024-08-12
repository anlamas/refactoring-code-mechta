<?php

declare(strict_types=1);

namespace vBulletin\Search;

class SearchRequest
{
    public function __construct(public ?int $searchId, public ?string $query)
    {
    }
}