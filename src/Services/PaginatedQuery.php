<?php

namespace MyBlog\Services;

use MyBlog\Managers\Database;
use Pagerfanta\Adapter\AdapterInterface;

class PaginatedQuery extends Database implements AdapterInterface
{
    private $pdo;
    private $query;
    private $countQuery;

    /**
     * PaginatedQuery constructor
     * 
     * @param \PDO $pdo
     * @param string $query Requête permettant de récupérer X résultats
     * @param string $countQuery Requête permettant de compter le nombre de résultats total
     */
    public function __construct(\PDO $pdo, $query, $countQuery)
    {
        $this->pdo = $pdo;
        $this->query = $query;
        $this->countQuery = $countQuery;
    }
    
    /**
     * Returns the number of results for the list.
     *
     * @return int
     */
    public function getNbResults()
    {
        return $this->pdo->query($this->countQuery)->fetchColumn();
    }

    /**
     * Returns an slice of the results representing the current page of items in the list.
     *
     * @param int $offset
     * @param int $length
     *
     * @return iterable
     */
    public function getSlice($offset, $length)
    {
        $stmt = $this->pdo->prepare($this->query . ' LIMIT :offset, :length');
        $stmt->bindParam(':offset', $offset, \PDO::PARAM_INT);
        $stmt->bindParam(':length', $length, \PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}