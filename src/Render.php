<?php

declare(strict_types=1);

namespace vBulletin;

use vBulletin\Search\SearchResult;

class Render
{
    public function renderSearchResult(SearchResult $searchResult): void
    {
        echo "<div class='search-result'>";
        echo "<h3>" . htmlspecialchars($searchResult->title, ENT_QUOTES, 'UTF-8') . "</h3>";
        echo "<p>" . htmlspecialchars($searchResult->text, ENT_QUOTES, 'UTF-8') . "</p>";
        echo "</div>";
        echo "<hr>";
    }

    public function renderSearchForm(): void
    {
        echo "<h2>Search in forum</h2><form><input name='q'></form>";
    }
}