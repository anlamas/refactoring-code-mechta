<?php

declare(strict_types=1);

namespace vBulletin\Search;

use PDO;
use vBulletin\Logger;
use vBulletin\Render;

class SearchService
{
    private Render $render;
    private Logger $logger;
    private SearchRepository $repository;

    public function __construct(SearchRepository $repository, Render $render, Logger $logger)
    {
        $this->render = $render;
        $this->logger = $logger;
        $this->repository = $repository;
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
        $results = $this->repository->getSearchResults($searchId);
        $this->renderSearchResults($results);
    }

    private function processSearch(string $query): void
    {
        $results = $this->repository->getPosts($query);
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