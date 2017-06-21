<?php

namespace Colibri\Core\Entity;

use Colibri\Connection\ConnectionInterface;
use Colibri\Connection\Statement\StatementIterator;
use Colibri\Connection\StmtInterface;
use Colibri\Core\ClassManager;
use Colibri\Core\Hydrator\AbstractHydratorEntity;
use Colibri\Core\ResultSet\ResultSet;
use Colibri\EventDispatcher\DispatcherInterface;
use Colibri\EventDispatcher\EventInterface;
use Colibri\Query\Builder\Delete;
use Colibri\Query\Builder\Insert;
use Colibri\Query\Builder\Select as SelectQueryBuilder;
use Colibri\Query\Builder\Select;
use Colibri\Query\Builder\Update;
use Colibri\Query\Statement\Comparison\Cmp;
use Colibri\ServiceContainer\ServiceLocatorInterface;

/**
 * Interface RepositoryInterface
 * @package Colibri\Core\Entity
 */
interface RepositoryInterface
{

  /**
   * @param array $criteria
   * @return StmtInterface
   */
  public function find(array $criteria);

  /**
   * @param $criteria
   * @return mixed
   */
  public function findOne($criteria);

  /**
   * @return mixed
   */
  public function findAll();

  /**
   * @param mixed $criteria
   * @return ResultSet
   */
  public function findBy($criteria);

  /**
   * @param $criteria
   * @return $this
   */
  public function filterBy($criteria);
  
  /**
   * @param integer $id
   * @return EntityInterface
   */
  public function retrieve($id);
  
  /**
   * @param EntityInterface $entity
   * @return EntityInterface
   */
  public function persist(EntityInterface $entity);

  /**
   * @param EntityInterface $entity
   * @return EntityInterface
   */
  public function remove(EntityInterface $entity);

  /**
   * @return string
   */
  public function getEntityName();

  /**
   * @return \ReflectionClass|\ReflectionObject
   */
  public function getEntityClassReflection();

  /**
   * @return MetadataInterface
   */
  public function getEntityMetadata();

  /**
   * @return SelectQueryBuilder
   */
  public function getQuery();

  /**
   * @return ClassManager
   */
  public function getClassManager();

  /**
   * @return ConnectionInterface
   */
  public function getConnection();
  
  /**
   * @return AbstractHydratorEntity
   */
  public function getHydrator();
  
  /**
   * @return DispatcherInterface
   */
  public function getEventDispatcher();
  
  /**
   * @param $eventName
   * @param EventInterface|null $event
   * @return $this
   */
  public function dispatchEvent($eventName, EventInterface $event = null);
  
  /**
   * @param $class
   * @return RepositoryInterface
   */
  public function getRepositoryFor($class);
  
  /**
   * @param $criteria
   * @return StatementIterator
   */
  public function executeCriteria($criteria);
  
  /**
   * @param integer $offset
   * @return RepositoryInterface
   */
  public function setOffset($offset);
  
  /**
   * @param integer $length
   * @return RepositoryInterface
   */
  public function setLimit($length);
  
  /**
   * @return ServiceLocatorInterface
   */
  public function getServiceLocator();

  /**
   * @return Select
   */
  public function createSelectQuery();

  /**
   * @return Insert
   */
  public function createInsertQuery();

  /**
   * @return Delete
   */
  public function createDeleteQuery();

  /**
   * @return Update
   */
  public function createUpdateQuery();

  /**
   * @return int
   */
  public function getResultSetMethod();

  /**
   * @param int $resultSetMethod
   */
  public function setResultSetMethod($resultSetMethod);

}