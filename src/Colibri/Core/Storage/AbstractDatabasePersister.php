<?php

namespace Colibri\Core\Storage;

use Colibri\Core\EntityManager;
use Colibri\Query\Builder as QueryBuilder;

/**
 * Class AbstractDatabasePersister
 * @package Colibri\Core\Persisters
 */
abstract class AbstractDatabasePersister implements PersisterInterface
{
  
  /**
   * @var EntityManager
   */
  protected $entityManager;
  
  
  public function __construct(EntityManager $entityManager)
  {
    $this->entityManager = $entityManager;
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
  
  /**
   * @return EntityManager
   */
  public function getEntityManager(): EntityManager
  {
    return $this->entityManager;
  }
  
}