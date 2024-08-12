<?php

declare(strict_types=1);

namespace vBulletin\Search;

use PDO;

class SearchRepository
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    /**
     * @param int $searchId
     * @return SearchResult[]
     */
    public function getSearchResults(int $searchId): array
    {
        $sth = $this->db->prepare('SELECT * FROM vb_search_results WHERE searchId = :searchId');
        $sth->execute([':searchId' => $searchId]);
        return $sth->fetchAll(PDO::FETCH_CLASS, SearchResult::class);
    }

    /**
     * @param string $query
     * @return SearchResult[]
     */
    public function getPosts(string $query): array
    {
        $sth = $this->db->prepare('SELECT * FROM vb_posts WHERE text LIKE :query');
        $sth->execute([':query' => '%' . $query . '%']);
        return $sth->fetchAll(PDO::FETCH_CLASS, SearchResult::class);
    }
}