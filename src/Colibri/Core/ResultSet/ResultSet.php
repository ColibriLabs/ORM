<?php

namespace Colibri\Core\ResultSet;

use Colibri\Collection\Collection;
use Colibri\Connection\Statement\StatementIterator;
use Colibri\Core\Collection\EntityCollection;
use Colibri\Core\Entity\RepositoryInterface;
use Colibri\Core\Entity\EntityInterface;
use Colibri\Core\Entity\MetadataInterface;
use Colibri\Core\Hydrator;
use Colibri\Core\Hydrator\AbstractHydratorEntity;

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
   * @return mixed
   */
  public function current()
  {
    /** @var EntityInterface $entity */
    $entity = $this->getReflection()->newInstance();
    $hydrator = $this->getHydrator();

    return $hydrator->hydrate(parent::current(), $entity);
  }

  /**
   * @return RepositoryInterface
   */
  public function getEntityRepository()
  {
    return $this->entityRepository;
  }

  /**
   * @return \ReflectionClass|\ReflectionObject
   */
  public function getReflection()
  {
    return $this->reflection;
  }

  /**
   * @return MetadataInterface
   */
  public function getMetadata()
  {
    return $this->getEntityRepository()->getEntityMetadata();
  }

  /**
   * @return Hydrator
   */
  public function getHydrator()
  {
    return $this->hydrator;
  }

  /**
   * @return array
   */
  public function getRawCollectionArray()
  {
    return iterator_to_array($this->getInnerIterator());
  }

  /**
   * @return array|EntityInterface[]
   */
  public function getCollectionArray()
  {
    return iterator_to_array($this);
  }

  /**
   * @return Collection
   */
  public function getRawCollection()
  {
    return new Collection($this->getRawCollectionArray());
  }

  /**
   * @return EntityCollection
   */
  public function getCollection()
  {
    return new EntityCollection($this->getCollectionArray());
  }
  
  public function getActiveRecordCollection()
  {
    
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
   * @return \Colibri\Connection\StmtInterface|\PDOStatement
   */
  public function getPdoStatementIterator()
  {
    return $this->getStatementIterator()->getStatement();
  }
  
  /**
   * @return bool
   */
  public function isEmpty()
  {
    return $this->count() === 0;
  }
  
  /**
   * @return bool
   */
  public function isNotEmpty()
  {
    return !$this->isEmpty();
  }
  
  /**
   * @return int
   */
  public function count()
  {
    return $this->getStatementIterator()->count();
  }
  
}