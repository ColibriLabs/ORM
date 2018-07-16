<?php

namespace Colibri\Core\Repository;

use Colibri\Connection\ConnectionInterface;
use Colibri\Core\Domain\MetadataInterface;
use Colibri\Core\Domain\RepositoryInterface;
use Colibri\Exception\NullPointerException;
use Colibri\Query\Builder as QueryBuilder;

/**
 * Abstract Class RepositoryQueryFactory
 * @package Colibri\Core\Repository
 */
abstract class AbstractRepositoryQueryFactory
{
    
    /**
     * @var RepositoryInterface
     */
    protected $repository;
    
    /**
     * @return QueryBuilder\Select
     * @throws NullPointerException
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
     * @return MetadataInterface
     * @throws NullPointerException
     */
    public function getEntityMetadata()
    {
        return $this->getRepository()->getEntityMetadata();
    }
    
    /**
     * @return RepositoryInterface
     * @throws NullPointerException
     */
    public function getRepository()
    {
        if (!($this->repository instanceof RepositoryInterface)) {
            throw new NullPointerException(sprintf('Repository was not initialized for %s', static::class));
        }
        
        return $this->repository;
    }
    
    /**
     * @param RepositoryInterface $repository
     *
     * @return $this
     */
    public function setRepository(RepositoryInterface $repository)
    {
        $this->repository = $repository;
        
        return $this;
    }
    
    /**
     * @return ConnectionInterface
     * @throws NullPointerException
     */
    public function getConnection()
    {
        return $this->getRepository()->getConnection();
    }
    
    /**
     * @return QueryBuilder\Insert
     * @throws NullPointerException
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
     * @throws NullPointerException
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
     * @throws NullPointerException
     */
    public function createUpdateQuery()
    {
        $metadata = $this->getEntityMetadata();
        $query = new QueryBuilder\Update($this->getConnection());
        
        $query->table($metadata->getTableName());
        
        return $query;
    }
    
}