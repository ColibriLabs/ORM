<?php

namespace Colibri\Core;

use Colibri\Common\Callback;
use Colibri\Common\Inflector;
use Colibri\Connection\ConnectionInterface;
use Colibri\Connection\Statement\StatementIterator;
use Colibri\Core\Entity\EntityInterface;
use Colibri\Core\Entity\MetadataInterface;
use Colibri\Core\Entity\RepositoryInterface;
use Colibri\Core\Event\EntityLifecycleEvent;
use Colibri\Core\Hydrator\AbstractHydratorEntity;
use Colibri\Core\Hydrator\EntityHydrator;
use Colibri\Core\Repository\GenericRepositoryQueryFactory;
use Colibri\Core\Repository\RepositoryQueryFactory;
use Colibri\Core\ResultSet\ResultSet;
use Colibri\Core\ResultSet\ResultSetIterator;
use Colibri\EventDispatcher\DispatcherInterface;
use Colibri\EventDispatcher\EventInterface;
use Colibri\Exception\BadCallMethodException;
use Colibri\Exception\InvalidArgumentException;
use Colibri\Exception\NotSupportedException;
use Colibri\Exception\RuntimeException;
use Colibri\Query\Builder as QueryBuilder;
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
  protected $filterQuery;
  
  /**
   * @var AbstractHydratorEntity
   */
  protected $hydrator;
  
  /**
   * @var DispatcherInterface
   */
  protected $eventDispatcher;
  
  /**
   * @var RepositoryQueryFactory
   */
  protected $queryFactory;
  
  /**
   * EntityRepository constructor.
   * @param string $entityName
   */
  public function __construct($entityName)
  {
    $this->serviceLocator = ServiceLocator::instance();
    
    $this->eventDispatcher = $this->serviceLocator->getDispatcher();
    $this->entityName = $entityName;
    $this->connection = $this->getServiceLocator()->getConnection($this->getEntityMetadata()->getConnectionName());
    $this->filterQuery = $this->createSelectQuery();
    
    $this->hydrator = new EntityHydrator($this);
    $this->queryFactory = new GenericRepositoryQueryFactory($this);
  }

  /**
   * @param $name
   * @param array $arguments
   * @return mixed
   * @throws BadCallMethodException
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

    throw new BadCallMethodException('Magic calling method should starts either :names', [
      'names' => 'findBy, findOneBy, filterBy, orderBy or groupBy'
    ]);
  }

  /**
   * @return QueryBuilder\Select
   */
  public function createSelectQuery()
  {
    return $this->getQueryFactory()->createSelectQuery();
  }

  /**
   * @return QueryBuilder\Insert
   */
  public function createInsertQuery()
  {
    return $this->getQueryFactory()->createInsertQuery();
  }

  /**
   * @return QueryBuilder\Delete
   */
  public function createDeleteQuery()
  {
    return $this->getQueryFactory()->createDeleteQuery();
  }

  /**
   * @return QueryBuilder\Update
   */
  public function createUpdateQuery()
  {
    return $this->getQueryFactory()->createUpdateQuery();
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
   * @param null $criteria
   * @return StatementIterator
   */
  public function executeCriteria($criteria = null)
  {
    $this->applyCriteria($criteria);

    $queryString = $this->getFilterQuery()->toSQL();
    $this->cleanupFilterQuery();

    return $this->executeStmtQuery($queryString);
  }

  /**
   * @param array $criteria
   * @return ResultSet
   */
  public function find(array $criteria)
  {
    return $this->findBy($criteria);
  }

  /**
   * @return ResultSet
   */
  public function findAll()
  {
    return $this->findBy(null);
  }

  /**
   * @param $criteria
   * @return EntityInterface
   */
  public function findOne($criteria = null)
  {
    $this->getFilterQuery()->setLimit(1);
    
    $resultSet = $this->findBy($criteria);
    $resultSet->rewind();

    return $resultSet->valid() ? $resultSet->current() : null;
  }

  /**
   * @param $criteria
   * @return EntityInterface
   */
  public function findOneBy($criteria)
  {
    return $this->findOne($criteria);
  }

  /**
   * @param mixed $criteria
   * @return ResultSet
   * @throws InvalidArgumentException
   * @throws NotSupportedException
   */
  public function findBy($criteria)
  {
    return new ResultSetIterator($this, $this->executeCriteria($criteria));
  }

  /**
   * @param $criteria
   * @return $this
   */
  public function filterBy($criteria)
  {
    $this->applyCriteria($criteria);

    return $this;
  }

  /**
   * @param string $criteria
   * @return $this
   */
  public function groupBy($criteria)
  {
    $this->getFilterQuery()->groupBy(...$criteria);

    return $this;
  }

  /**
   * @param $criteria
   * @return $this
   */
  public function orderBy($criteria)
  {
    $this->getFilterQuery()->orderBy(...$criteria);

    return $this;
  }

  /**
   * @param EntityInterface $entity
   * @return bool
   * @throws RuntimeException
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
   * @param int $id
   * @return EntityInterface
   */
  public function retrieve($id)
  {
    return $this->findOne($id);
  }

  /**
   * @param EntityInterface $entity
   * @return $this
   * @throws NotSupportedException
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

    throw new NotSupportedException('Unable persist entity, because current repository is not compatible with passed entity');
  }

  /**
   * @param EntityInterface $entity
   * @return $this
   * @throws NotSupportedException
   */
  public function remove(EntityInterface $entity)
  {
    $reflection = $this->getEntityClassReflection();
    
    if ($reflection->isInstance($entity)) {
      $metadata = $this->getEntityMetadata();
      $deletion = $this->createDeleteQuery();
      
      if (null !== ($identifier = $metadata->getIdentifier())) {
        
        $connection = $this->getConnection();
        $propertyIdentifier = $metadata->getName($identifier, Metadata::CAMILIZED);
  
        $entity->beforeRemove();
        $this->dispatchEvent(ORMEvents::beforeRemove, new EntityLifecycleEvent($this, $entity));
        
        $deletion->addConditions($identifier, $entity->getByProperty($propertyIdentifier));
        $deletion->setLimit(1)->setOffset(0);
        
        $connection->transaction(function() use ($connection, $deletion) {
          $connection->execute($deletion->toSQL());
        });
  
        $entity->setByProperty($propertyIdentifier, null);
        
        return $this;
      } else {
        throw new NotSupportedException('This case not implemented yet...');
      }
      
    }
    
    throw new NotSupportedException('Unable persist entity, because current repository is not compatible with passed entity');
  }
  
  /**
   * @param EntityInterface $entity
   * @return QueryBuilder\Insert|QueryBuilder\Update
   */
  public function getPersisterForEntity(EntityInterface $entity)
  {
    return $this->isNewEntity($entity) ? $this->createInsertQuery() : $this->createUpdateQuery();
  }

  /**
   * @return mixed
   */
  public function getEntityName()
  {
    return $this->entityName;
  }

  /**
   * @return \ReflectionClass|\ReflectionObject
   */
  public function getEntityClassReflection()
  {
    return $this->getClassManager()->getReflection($this->getEntityName());
  }

  /**
   * @return MetadataInterface
   */
  public function getEntityMetadata()
  {
    return $this->getServiceLocator()->getMetadataManager()->getMetadataFor($this->getEntityName());
  }

  /**
   * @return QueryBuilder\Select
   */
  public function getFilterQuery()
  {
    return $this->filterQuery;
  }
  
  /**
   * @param int $offset
   * @return $this
   */
  public function setOffset($offset)
  {
    $this->getFilterQuery()->offset($offset);
  
    return $this;
  }
  
  /**
   * @param int $length
   * @return $this
   */
  public function setLimit($length)
  {
    $this->getFilterQuery()->limit($length);
    
    return $this;
  }
  
  /**
   * @return $this
   */
  public function cleanupFilterQuery()
  {
    $metadata = $this->getEntityMetadata();
    $query = $this->getFilterQuery();

    $query->cleanup();
    $query->addSelectColumns($metadata->getSelectColumns());

    return $this;
  }

  /**
   * @param QueryBuilder\Select $filterQuery
   * @return $this
   */
  public function setFilterQuery(QueryBuilder\Select $filterQuery)
  {
    $this->filterQuery = $filterQuery;

    return $this;
  }
  
  /**
   * @return ClassManager
   */
  public function getClassManager()
  {
    return $this->getServiceLocator()->getClassManager();
  }

  /**
   * @return ConnectionInterface
   */
  public function getConnection()
  {
    return $this->connection;
  }

  /**
   * @return ServiceLocatorInterface
   */
  public function getServiceLocator()
  {
    return $this->serviceLocator;
  }
  
  /**
   * @return AbstractHydratorEntity
   */
  public function getHydrator()
  {
    return $this->hydrator;
  }
  
  /**
   * @return DispatcherInterface
   */
  public function getEventDispatcher()
  {
    return $this->eventDispatcher;
  }
  
  /**
   * @return RepositoryQueryFactory
   */
  public function getQueryFactory()
  {
    return $this->queryFactory;
  }
  
  /**
   * @param RepositoryQueryFactory $queryFactory
   * @return $this
   */
  public function setQueryFactory(RepositoryQueryFactory $queryFactory)
  {
    $this->queryFactory = $queryFactory;
    
    return $this;
  }
  
  /**
   * @param $eventName
   * @param EventInterface $event
   * @return $this
   */
  public function dispatchEvent($eventName, EventInterface $event = null)
  {
    $this->getEventDispatcher()->dispatch($eventName, $event);
    
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

    if ($query === null) {
      $query = $this->getFilterQuery()->toSQL();
    }

    $connection->transaction(function (ConnectionInterface $connection) use ($query) {
      $connection->execute($query);
    });

    return $connection->affectedRows();
  }

  /**
   * @param null $query
   * @return StatementIterator
   */
  public function executeStmtQuery($query = null)
  {
    $connection = $this->getConnection();

    if ($query === null) {
      $query = $this->getFilterQuery()->toSQL();
    }

    return new StatementIterator($connection->query($query));
  }
  
  /**
   * @param $criteria
   * @return $this
   * @throws NotSupportedException
   */
  protected function applyCriteria($criteria)
  {
    $query = $this->getFilterQuery();
    $metadata = $this->getEntityMetadata();

    if (null !== $criteria) {
      switch (true) {
        case is_scalar($criteria):
          $query->addConditions($metadata->getIdentifier(), $criteria);
          break;
          
        case $criteria instanceof QueryBuilder\Select:
          $criteria->setFromTable($metadata->getTableName());
          $this->setFilterQuery($criteria);
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

}