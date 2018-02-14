<?php

/************************************************
 * This file is part of ColibriLabs package     *
 * @copyright (c) 2016-2018 Ivan Hontarenko     *
 * @email ihontarenko@gmail.com                 *
 ************************************************/

namespace Colibri\Core;

use Colibri\Common\Callback;
use Colibri\Common\Inflector;
use Colibri\Connection\ConnectionInterface;
use Colibri\Connection\Statement\StatementIterator;
use Colibri\Core\Domain\EntityInterface;
use Colibri\Core\Domain\MetadataInterface;
use Colibri\Core\Domain\RepositoryInterface;
use Colibri\Core\Event\EntityLifecycleEvent;
use Colibri\Core\Hydrator\AbstractHydratorEntity;
use Colibri\Core\Hydrator\EntityHydrator;
use Colibri\Core\Repository\BasicRepositoryQueryFactory;
use Colibri\Core\Repository\AbstractRepositoryQueryFactory;
use Colibri\Core\ResultSet\ResultSet;
use Colibri\Core\ResultSet\ResultSetIterator;
use Colibri\EventDispatcher\DispatcherInterface;
use Colibri\EventDispatcher\EventInterface;
use Colibri\Exception\BadArgumentException;
use Colibri\Exception\BadCallMethodException;
use Colibri\Exception\NotFoundException;
use Colibri\Exception\NotSupportedException;
use Colibri\Query\Builder as QueryBuilder;
use Colibri\Query\Criteria;
use Colibri\ServiceContainer\ServiceLocator;
use Colibri\ServiceContainer\ServiceLocatorInterface;

/**
 * Class EntityRepository
 * @package Colibri\Core
 */
abstract class Repository implements RepositoryInterface
{
  
  /**
   * @const string
   */
  const MAGIC_CALL_REGEXP = '/^(findBy|findOneBy|filterBy|orderBy|groupBy)([a-z0-9]+)$/ui';
  
  /**
   * @const integer
   */
  const RESULT_ITERABLE = 1;
  
  /**
   * @const integer
   */
  const RESULT_COLLECTION = 2;
  
  /**
   * @var string
   */
  protected $entityName;
  
  /**
   * @var ServiceLocatorInterface
   */
  protected $serviceLocator;
  
  /**
   * @var ConnectionInterface
   */
  protected $connection;
  
  /**
   * @var QueryBuilder\Select
   */
  protected $query;
  
  /**
   * @var AbstractHydratorEntity
   */
  protected $hydrator;
  
  /**
   * @var DispatcherInterface
   */
  protected $eventDispatcher;
  
  /**
   * @var AbstractRepositoryQueryFactory
   */
  protected $queryFactory;
  
  /**
   * EntityRepository constructor.
   * @param string $entityName
   * @throws NotFoundException
   */
  public function __construct($entityName)
  {
    $this->serviceLocator = ServiceLocator::instance();
    
    $this->eventDispatcher = $this->serviceLocator->getDispatcher();
    $this->entityName = $entityName;
    $this->connection = $this->getServiceLocator()->getConnection($this->getEntityMetadata()->getConnectionName());
    
    $this->setHydrator(new EntityHydrator($this));
    $this->setQueryFactory(new BasicRepositoryQueryFactory());
    
    $this->query = $this->createSelectQuery();
  }
  
  /**
   * @param       $name
   * @param array $arguments
   * @return mixed
   * @throws BadArgumentException
   * @throws BadCallMethodException
   * @throws NotFoundException
   */
  public function __call($name, array $arguments = [])
  {
    preg_match(static::MAGIC_CALL_REGEXP, $name, $matches);
    
    if (isset($matches[0])) {
      $metadata = $this->getEntityMetadata();
      
      array_shift($matches);
      
      list($methodName, $columnName) = $matches;
      
      $columnName = $metadata->getRawSQLName(Inflector::underscore($columnName));
      array_unshift($arguments, $columnName);
      
      $callback = new Callback([$this, $methodName]);
      
      return $callback->call($arguments);
    }
    
    throw new BadCallMethodException(sprintf('Trying to call %s::%s(); method. Allowed to call methods which starts with "%s"',
      static::class, $name, 'findBy, findOneBy, filterBy, orderBy or groupBy'));
  }
  
  /**
   * @return ServiceLocatorInterface
   */
  public function getServiceLocator()
  {
    return $this->serviceLocator;
  }
  
  /**
   * @return MetadataInterface
   * @throws NotFoundException
   */
  public function getEntityMetadata()
  {
    return $this->getServiceLocator()->getMetadataManager()->getMetadataFor($this->getEntityName());
  }
  
  /**
   * @return mixed
   */
  public function getEntityName()
  {
    return $this->entityName;
  }
  
  /**
   * @return QueryBuilder\Select
   */
  public function createSelectQuery()
  {
    return $this->getQueryFactory()->createSelectQuery();
  }
  
  /**
   * @return AbstractRepositoryQueryFactory
   */
  public function getQueryFactory()
  {
    return $this->queryFactory;
  }
  
  /**
   * @param AbstractRepositoryQueryFactory $queryFactory
   * @return $this
   */
  public function setQueryFactory(AbstractRepositoryQueryFactory $queryFactory)
  {
    $queryFactory->setRepository($this);
    
    $this->queryFactory = $queryFactory;
    
    return $this;
  }
  
  /**
   * @param $class
   * @return RepositoryInterface
   */
  public function getRepositoryFor($class)
  {
    return $this->getServiceLocator()->getRepositoryManager()->getRepositoryFor($class);
  }
  
  /**
   * @param array $criteria
   * @return ResultSet
   * @throws NotSupportedException
   * @throws NotFoundException
   */
  public function find(array $criteria)
  {
    return $this->findBy($criteria);
  }
  
  /**
   * @param mixed $criteria
   * @return ResultSet
   * @throws NotSupportedException
   * @throws NotFoundException
   */
  public function findBy($criteria)
  {
    return new ResultSetIterator($this, $this->executeCriteria($criteria));
  }
  
  /**
   * @param null $criteria
   * @return StatementIterator
   * @throws NotSupportedException
   * @throws NotFoundException
   */
  public function executeCriteria($criteria = null)
  {
    return $this->applyCriteria($criteria)->executeQueryStmt();
  }
  
  /**
   * @return StatementIterator
   * @throws NotFoundException
   */
  public function executeQueryStmt()
  {
    $selectQuery = $this->getQuery();
    $statement = $this->getConnection()->prepare($this->getQuery(), []);
    
    // if query builder was initialized as parameterized
    // and it have what to bind to PDOStatement
    if ($selectQuery->isParameterized() && count($selectQuery->getPlaceholders()) > 0) {
      $statement->bindParams($this->getQuery()->getPlaceholders());
    }
    
    // executes a prepared statement
    $statement->execute();
    
    // reset qb to previous state
    $this->cleanupQuery();
    
    return new StatementIterator($statement);
  }
  
  /**
   * @return QueryBuilder\Select
   */
  public function getQuery()
  {
    return $this->query;
  }
  
  /**
   * @param QueryBuilder\Select $filterQuery
   * @return $this
   */
  public function setQuery(QueryBuilder\Select $filterQuery)
  {
    $this->query = $filterQuery;
    
    return $this;
  }
  
  /**
   * @return ConnectionInterface
   */
  public function getConnection()
  {
    return $this->connection;
  }
  
  /**
   * @return $this
   * @throws NotFoundException
   */
  public function cleanupQuery()
  {
    $metadata = $this->getEntityMetadata();
    $query = $this->getQuery();
    
    $query->cleanup();
    $query->addSelectColumns($metadata->getSelectColumns());
    
    return $this;
  }
  
  /**
   * @param $criteria
   * @return $this
   * @throws NotSupportedException
   * @throws NotFoundException
   */
  protected function applyCriteria($criteria)
  {
    $query = $this->getQuery();
    $metadata = $this->getEntityMetadata();
    
    if (null !== $criteria) {
      switch (true) {
        case is_scalar($criteria):
          $identifier = $metadata->getRawSQLName($metadata->getIdentifier());
          $query->addConditions($identifier, $criteria);
          break;
        
        case $criteria instanceof QueryBuilder\Select:
          $criteria->setFromTable($metadata->getTableName());
          $this->setQuery($criteria);
          break;
        
        case (is_array($criteria) and count($criteria) > 0):
          $query->addConditions(...$criteria);
          break;
        
        default:
          throw new NotSupportedException('It is impossible to determine the correct assignment criteria');
          break;
      }
    }
    
    return $this;
  }
  
  /**
   * @return ResultSet
   * @throws NotSupportedException
   * @throws NotFoundException
   */
  public function findAll()
  {
    return $this->findBy(null);
  }
  
  /**
   * @param $criteria
   * @return $this
   * @throws NotSupportedException
   * @throws NotFoundException
   */
  public function filterBy($criteria)
  {
    $this->applyCriteria($criteria);
    
    return $this;
  }
  
  /**
   * @param string $criteria
   * @return $this
   * @throws BadArgumentException
   */
  public function groupBy($criteria)
  {
    $this->getQuery()->groupBy(...$criteria);
    
    return $this;
  }
  
  /**
   * @param $criteria
   * @return $this
   */
  public function orderBy($criteria)
  {
    $this->getQuery()->orderBy(...$criteria);
    
    return $this;
  }
  
  /**
   * @param int $id
   * @return EntityInterface
   * @throws BadArgumentException
   * @throws NotSupportedException
   * @throws NotFoundException
   */
  public function retrieve($id)
  {
    return $this->findOneBy((integer)$id);
  }
  
  /**
   * @param $criteria
   * @return EntityInterface
   * @throws BadArgumentException
   * @throws NotSupportedException
   * @throws NotFoundException
   */
  public function findOneBy($criteria)
  {
    if (in_array($criteria, [null, false], true)) {
      throw new BadArgumentException(sprintf('Method "%s" could not been invoked with empty criteria', __METHOD__));
    }
    
    return $this->findFirst($criteria);
  }
  
  /**
   * @param $criteria
   * @return EntityInterface
   * @throws NotSupportedException
   * @throws NotFoundException
   */
  public function findFirst($criteria = null)
  {
    $this->getQuery()->setLimit(1);
    
    $resultSet = $this->findBy($criteria);
    $resultSet->rewind();
    
    return $resultSet->valid() ? $resultSet->current() : null;
  }
  
  /**
   * @param EntityInterface $entity
   * @return $this
   * @throws NotSupportedException
   * @throws NotFoundException
   */
  public function persist(EntityInterface $entity)
  {
    $reflection = $this->getEntityClassReflection();
    
    if ($reflection->isInstance($entity)) {
      
      $entity->beforePersist();
      
      $connection = $this->getConnection();
      $metadata = $this->getEntityMetadata();
      $isEntityNew = $this->isNewEntity($entity);
      $entityData = [];
      
      $this->dispatchEvent(ORMEvents::beforePersist, new EntityLifecycleEvent($this, $entity));
      
      foreach ($this->getHydrator()->extract($entity) as $sqlName => $value) {
        if ($sqlName !== $metadata->getIdentifier() && null !== $value) {
          $entityData[$metadata->getRawSQLName($metadata->getName($sqlName))] = $value;
        }
      }
      
      $persister = $this->getPersisterForEntity($entity);
      $persister->setDataBatch($entityData);
      
      $propertyIdentifier = $metadata->getName($metadata->getIdentifier(), Metadata::CAMILIZED);
      
      
      if (!$isEntityNew && $reflection->hasProperty($propertyIdentifier)) {
        $persister->addConditions($metadata->getIdentifier(), $entity->getByProperty($propertyIdentifier));
      }
      
      $connection->start();
      $connection->execute($persister->toSQL());
      
      if ($reflection->hasProperty($propertyIdentifier) && $isEntityNew) {
        $reflection->getProperty($propertyIdentifier)->setValue($entity, $connection->lastInsertId());
      }
      
      $this->dispatchEvent(ORMEvents::afterPersist, new EntityLifecycleEvent($this, $entity));
      
      $connection->commit();
      
      return $this;
    }
    
    throw new NotSupportedException(sprintf('Unable to persist entity! Actual entity "%s" expected entity "%s"',
      get_class($entity), $this->getEntityName()));
  }
  
  /**
   * @param EntityInterface $entity
   * @return $this
   * @throws NotSupportedException
   * @throws NotFoundException
   */
  public function remove(EntityInterface $entity)
  {
    $reflection = $this->getEntityClassReflection();
    
    if ($reflection->isInstance($entity)) {
      $metadata = $this->getEntityMetadata();
      $remover = $this->createDeleteQuery();
      $identifier = $this->getEntityIdentifier();
      
      $connection = $this->getConnection();
      $propertyIdentifier = $metadata->getName($identifier, Metadata::CAMILIZED);
      $event = new EntityLifecycleEvent($this, $entity);

      // die(var_dump((string)$remover));
      
      // trigger event for entity and dispatcher on before remove
      $entity->beforeRemove();
      $this->dispatchEvent(ORMEvents::beforeRemove, $event);
      
      // refinement of the request
      $remover->addConditions($identifier, $entity->getByProperty($propertyIdentifier));
      $remover->setLimit(1)->setOffset(0);
      
      // open transaction and try to execute sql
      $connection->transaction(function () use ($connection, $remover) {
        $connection->execute($remover->toSQL());
      });
      
      // trigger event for entity and dispatcher on after remove
      $entity->afterRemove();
      $this->dispatchEvent(ORMEvents::afterRemove, $event);
      
      // reset identifier for removed entity
      $entity->setByProperty($propertyIdentifier, null);
      
      return $this;
    }
    
    throw new NotSupportedException(sprintf('Unable to remove entity! Actual entity "%s" expected entity "%s"',
      get_class($entity), $this->getEntityName()));
  }
  
  /**
   * @return \ReflectionClass|\ReflectionObject
   */
  public function getEntityClassReflection()
  {
    return $this->getClassManager()->getReflection($this->getEntityName());
  }
  
  /**
   * @return string
   * @throws NotFoundException
   */
  public function getEntityIdentifier()
  {
    $identifier = $this->getEntityMetadata()->getIdentifier();
    
    if (null === $identifier) {
      throw new NotFoundException(sprintf('Cannot determine identifier name for "%s" entity',
        $this->getEntityName()));
    }
    
    return $identifier;
  }
  
  /**
   * @return ClassManager
   */
  public function getClassManager()
  {
    return $this->getServiceLocator()->getClassManager();
  }
  
  /**
   * @param EntityInterface $entity
   * @return bool
   * @throws NotFoundException
   */
  public function isNewEntity(EntityInterface $entity)
  {
    $reflection = $this->getEntityClassReflection();
    $metadata = $this->getEntityMetadata();
    $identifier = $metadata->getName($metadata->getIdentifier(), Metadata::CAMILIZED);
    
    return null !== $identifier
      ? ($reflection->getProperty($identifier)->getValue($entity) === null) : true;
  }
  
  /**
   * @param                $eventName
   * @param EventInterface $event
   * @return $this
   */
  public function dispatchEvent($eventName, EventInterface $event = null)
  {
    $this->getEventDispatcher()->dispatch($eventName, $event);
    
    return $this;
  }
  
  /**
   * @return DispatcherInterface
   */
  public function getEventDispatcher()
  {
    return $this->eventDispatcher;
  }
  
  /**
   * @return AbstractHydratorEntity
   */
  public function getHydrator()
  {
    return $this->hydrator;
  }
  
  /**
   * @param AbstractHydratorEntity $hydrator
   * @return $this
   */
  public function setHydrator(AbstractHydratorEntity $hydrator)
  {
    $this->hydrator = $hydrator;
    
    return $this;
  }
  
  /**
   * @param EntityInterface $entity
   * @return QueryBuilder\Insert|QueryBuilder\Update
   * @throws NotFoundException
   */
  public function getPersisterForEntity(EntityInterface $entity)
  {
    return $this->isNewEntity($entity) ? $this->createInsertQuery() : $this->createUpdateQuery();
  }
  
  /**
   * @return QueryBuilder\Insert
   */
  public function createInsertQuery()
  {
    return $this->getQueryFactory()->createInsertQuery();
  }
  
  /**
   * @return QueryBuilder\Update
   */
  public function createUpdateQuery()
  {
    return $this->getQueryFactory()->createUpdateQuery();
  }
  
  /**
   * @return QueryBuilder\Delete
   */
  public function createDeleteQuery()
  {
    return $this->getQueryFactory()->createDeleteQuery();
  }
  
  /**
   * @param int $offset
   * @return $this
   */
  public function setOffset($offset)
  {
    $this->getQuery()->offset($offset);
    
    return $this;
  }
  
  /**
   * @param int $length
   * @return $this
   */
  public function setLimit($length)
  {
    $this->getQuery()->limit($length);
    
    return $this;
  }
  
  /**
   * @param Criteria $criteria
   * @return $this
   */
  public function setCriteria(Criteria $criteria)
  {
    $this->setQuery($criteria->getSelectBuilderObject());
    
    return $this;
  }
  
  /**
   * @param EntityInterface $entity
   * @param array           $entityData
   * @return $this
   */
  public function hydrate(EntityInterface $entity, array $entityData)
  {
    $this->getHydrator()->hydrate($entityData, $entity);
    
    return $this;
  }
  
  /**
   * @param EntityInterface $entity
   * @return array
   */
  public function extract(EntityInterface $entity)
  {
    return $this->getHydrator()->extract($entity);
  }
  
  /**
   * @param null $query
   * @return mixed
   */
  public function executeQuery($query = null)
  {
    $connection = $this->getConnection();
    
    $connection->transaction(function (ConnectionInterface $connection) use ($query) {
      $connection->execute($query);
    });
    
    return $connection->affectedRows();
  }
  
}
