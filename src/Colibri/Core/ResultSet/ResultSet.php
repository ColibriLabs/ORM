<?php

namespace Colibri\Core\ResultSet;

use Colibri\Collection\Collection;
use Colibri\Connection\Statement\StatementIterator;
use Colibri\Core\Collection\ActiveEntityCollection;
use Colibri\Core\Collection\EntityCollection;
use Colibri\Core\Domain\EntityInterface;
use Colibri\Core\Domain\MetadataInterface;
use Colibri\Core\Domain\RepositoryInterface;
use Colibri\Core\Hydrator;
use Colibri\Core\Metadata;
use Colibri\Exception\NotFoundException;

/**
 * Class ResultSetIterator
 * @package Colibri\Core
 */
abstract class ResultSet extends \IteratorIterator implements \Countable
{
    
    /**
     * @var RepositoryInterface
     */
    protected $entityRepository;
    
    /**
     * @var \ReflectionClass|\ReflectionObject
     */
    protected $reflection;
    
    /**
     * @var Hydrator
     */
    protected $hydrator;
    
    /**
     * @var string|integer
     */
    protected $currentKey;
    
    /**
     * @return EntityInterface
     * @throws NotFoundException
     */
    public function current()
    {
        /** @var EntityInterface $entity */
        $reflection = $this->getReflection();
        $entity = $reflection->newInstance();
        $hydrator = $this->getHydrator();
        $repository = $this->getEntityRepository();
        $metadata = $this->getMetadata();
        
        $entity = $hydrator->hydrate(parent::current(), $entity);
        
        $identifier = $repository->getEntityIdentifier();
        $identifier = $metadata->getName($identifier, Metadata::CAMILIZED);
        
        $this->currentKey = $reflection->getProperty($identifier)->getValue($entity);
        
        return $entity;
    }
    
    /**
     * @return \ReflectionClass|\ReflectionObject
     */
    public function getReflection()
    {
        return $this->reflection;
    }
    
    /**
     * @return Hydrator
     */
    public function getHydrator()
    {
        return $this->hydrator;
    }
    
    /**
     * @return RepositoryInterface
     */
    public function getEntityRepository()
    {
        return $this->entityRepository;
    }
    
    /**
     * @return MetadataInterface
     */
    public function getMetadata()
    {
        return $this->getEntityRepository()->getEntityMetadata();
    }
    
    /**
     * @return string|integer
     */
    public function key()
    {
        return $this->currentKey;
    }
    
    /**
     * @return Collection
     */
    public function getRawCollection()
    {
        return new Collection($this->getRawCollectionArray());
    }
    
    /**
     * @return array
     */
    public function getRawCollectionArray()
    {
        return iterator_to_array($this->getInnerIterator());
    }
    
    /**
     * @return EntityCollection
     */
    public function getCollection()
    {
        return new EntityCollection($this->getCollectionArray());
    }
    
    /**
     * @return array|EntityInterface[]
     */
    public function getCollectionArray()
    {
        return iterator_to_array($this);
    }
    
    /**
     * @return ActiveEntityCollection
     */
    public function getActiveRecordCollection()
    {
        return new ActiveEntityCollection($this->getEntityRepository(), $this->getCollectionArray());
    }
    
    /**
     * @return \Colibri\Connection\StmtInterface|\PDOStatement
     */
    public function getPdoStatementIterator()
    {
        return $this->getStatementIterator()->getStatement();
    }
    
    /**
     * @return StatementIterator
     */
    public function getStatementIterator()
    {
        /** @var StatementIterator $iterator */
        $iterator = $this->getInnerIterator();
        
        return $iterator;
    }
    
    /**
     * @return bool
     */
    public function isNotEmpty()
    {
        return !$this->isEmpty();
    }
    
    /**
     * @return bool
     */
    public function isEmpty()
    {
        return $this->count() === 0;
    }
    
    /**
     * @return int
     */
    public function count()
    {
        return $this->getStatementIterator()->count();
    }
    
}
