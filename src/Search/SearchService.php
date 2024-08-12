<?php

declare(strict_types=1);

namespace vBulletin\Search;

use PDO;
use vBulletin\Logger;
use vBulletin\Render;

class SearchService
{
    private PDO $db;
    private Render $render;
    private Logger $logger;

    public function __construct(PDO $db, Render $render, Logger $logger)
    {
        $this->db = $db;
        $this->render = $render;
        $this->logger = $logger;
    }

    public function search(SearchRequest $request): void
    {
        if ($request->searchId !== null) {
            $this->showResults($request->searchId);
        } elseif (!empty($request->query)) {
            $this->processSearch($request->query);
        } else {
            $this->render->renderSearchForm();
        }
    }

    private function showResults(int $searchId): void
    {
        $sth = $this->db->prepare('SELECT * FROM vb_search_results WHERE searchId = :searchId');
        $sth->execute([':searchId' => $searchId]);
        $results = $sth->fetchAll(PDO::FETCH_CLASS, SearchResult::class);
        $this->renderSearchResults($results);
    }

    private function processSearch(string $query): void
    {
        $sth = $this->db->prepare('SELECT * FROM vb_posts WHERE text LIKE :query');
        $sth->execute([':query' => '%' . $query . '%']);
        $results = $sth->fetchAll(PDO::FETCH_CLASS, SearchResult::class);
        $this->renderSearchResults($results);
        $this->logger->log($query);
    }

    /**
     * @param SearchResult[] $results
     * @return void
     */
    private function renderSearchResults(array $results): void
    {
        foreach ($results as $searchResult) {
            if ($searchResult->forumId != 5) {
                $this->render->renderSearchResult($searchResult);
            }
        }
    }
}