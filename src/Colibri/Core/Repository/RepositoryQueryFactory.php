<?php

namespace Colibri\Core\Repository;

use Colibri\Query\Builder as QueryBuilder;
use Colibri\Connection\ConnectionInterface;
use Colibri\Core\Domain\MetadataInterface;
use Colibri\Core\Domain\RepositoryInterface;

/**
 * Abstract Class RepositoryQueryFactory
 * @package Colibri\Core\Repository
 */
abstract class RepositoryQueryFactory
{
  
  /**
   * @var RepositoryInterface
   */
  protected $repository;
  
  /**
   * RepositoryQueryFactory constructor.
   * @param RepositoryInterface $repository
   */
  public function __construct(RepositoryInterface $repository)
  {
    $this->repository = $repository;
  }
  
  /**
   * @return RepositoryInterface
   */
  public function getRepository()
  {
    return $this->repository;
  }
  
  /**
   * @return MetadataInterface
   */
  public function getEntityMetadata()
  {
    return $this->getRepository()->getEntityMetadata();
  }
  
  /**
   * @return ConnectionInterface
   */
  public function getConnection()
  {
    return $this->getRepository()->getConnection();
  }
  
  /**
   * @return QueryBuilder\Select
   */
  public function createSelectQuery()
  {
    $metadata = $this->getEntityMetadata();
    $query = new QueryBuilder\Select($this->getConnection());
    
    $query->setFromTable($metadata->getTableName());
    $query->addSelectColumns($metadata->getSelectColumns());
    
    return $query;
  }
  
  /**
   * @return QueryBuilder\Insert
   */
  public function createInsertQuery()
  {
    $metadata = $this->getEntityMetadata();
    $query = new QueryBuilder\Insert($this->getConnection());
    
    $query->setTableInto($metadata->getTableName());
    
    return $query;
  }
  
  /**
   * @return QueryBuilder\Delete
   */
  public function createDeleteQuery()
  {
    $metadata = $this->getEntityMetadata();
    $query = new QueryBuilder\Delete($this->getConnection());
    
    $query->setFromTable($metadata->getTableName());
    
    return $query;
  }
  
  /**
   * @return QueryBuilder\Update
   */
  public function createUpdateQuery()
  {
    $metadata = $this->getEntityMetadata();
    $query = new QueryBuilder\Update($this->getConnection());
    
    $query->table($metadata->getTableName());
    
    return $query;
  }
  
}