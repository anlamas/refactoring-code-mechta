<?php

declare(strict_types=1);

namespace vBulletin\Search;

class SearchResult
{
    public function __construct(public int $forumId, public string $text, public string $title)
    {
    }
}