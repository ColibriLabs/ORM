<?php

namespace Colibri\Pagination;

use Colibri\Connection\StmtInterface;
use Colibri\Core\Entity\RepositoryInterface;
use Colibri\Core\ResultSet\ResultSet;
use Colibri\Query\Expr\Column;
use Colibri\Query\Expr\Func\Count;

/**
 * Class Paginator
 * @package Colibri\Pagination
 */
class Paginator implements \IteratorAggregate
{
  
  /**
   * @var int
   */
  protected $currentPage = 1;
  
  /**
   * @var int
   */
  protected $countPerPage = 10;
  
  /**
   * @var int
   */
  protected $totalPages = 1;

  /**
   * @var RepositoryInterface
   */
  protected $repository;
  
  /**
   * Paginator constructor.
   * @param RepositoryInterface $repository
   */
  public function __construct(RepositoryInterface $repository)
  {
    $this->repository = $repository;
  }
  
  /**
   * @return $this
   */
  public function processRepository()
  {
    $repository = $this->getRepository();
    
    $this->determineTotalPages();
  
    $currentPage = max(0, min($this->getTotalPages(), $this->getCurrentPage()) - 1);
    
    $repository->setLimit($this->getCountPerPage());
    $repository->setOffset($currentPage * $this->getCountPerPage());
    
    return $this;
  }
  
  /**
   * @return $this
   */
  public function determineTotalPages()
  {
    $repository = $this->getRepository();
    $queryBuild = clone $repository->getQuery();
    $metadata   = $repository->getEntityMetadata();
    $connection = $repository->getConnection();
  
    $identifier = $metadata->getIdentifier();
    $identifier = $metadata->getRawSQLName($identifier);

    $queryBuild->clearSelectColumns();
    $queryBuild->addSelectColumn(new Count(new Column($identifier), true), 'totalRows');
    $queryBuild->clearGroupByColumns();

    /** @var StmtInterface|\PDOStatement $statement */
    $statement = $connection->query($queryBuild->toSQL());
    
    $totalRows = $statement->fetchColumn(0);
    $this->totalPages = (integer) ceil($totalRows / $this->getCountPerPage());
    
    return $this;
  }
  
  /**
   * @return int
   */
  public function getCurrentPage()
  {
    return $this->currentPage;
  }
  
  /**
   * @return int
   */
  public function getCountPerPage()
  {
    return $this->countPerPage;
  }
  
  /**
   * @return int
   */
  public function getTotalPages()
  {
    return $this->totalPages;
  }
  
  /**
   * @return RepositoryInterface
   */
  public function getRepository()
  {
    return $this->repository;
  }
  
  /**
   * @param int $currentPage
   * @return $this
   */
  public function setCurrentPage($currentPage)
  {
    $this->currentPage = $currentPage;
    
    return $this;
  }
  
  /**
   * @param int $countPerPage
   * @return $this
   */
  public function setCountPerPage($countPerPage)
  {
    $this->countPerPage = $countPerPage;
    
    return $this;
  }
  
  /**
   * @return ResultSet
   */
  public function getIterator()
  {
    $this->processRepository();
    
    return $this->getRepository()->findAll();
  }
  
}
