<?php

namespace Colibri\Core;

use Colibri\Core\Domain\EntityInterface;
use Colibri\ServiceContainer\ServiceLocatorInterface;

/**
 * Class EntityManager
 * @package Colibri\Core
 */
class EntityManager
{
  
  /**
   * @var ServiceLocatorInterface
   */
  protected $serviceLocator;
  
  protected $toPersistEntities;
  
  /**
   * EntityManager constructor.
   * @param ServiceLocatorInterface $serviceLocator
   */
  public function __construct(ServiceLocatorInterface $serviceLocator)
  {
    $this->serviceLocator = $serviceLocator;
  }
  
  /**
   * @param EntityInterface $entity
   * @param bool $forcePersist
   * @return $this
   */
  public function persist(EntityInterface $entity, $forcePersist = false)
  {
    
    return $this;
  }
  
  /**
   * @param EntityInterface $entity
   * @param bool $forceRemove
   * @return $this
   */
  public function remove(EntityInterface $entity, $forceRemove = false)
  {
    
    return $this;
  }
  
  /**
   * @param $class
   * @return Metadata
   */
  public function getMetadataFor($class)
  {
    return $this->getMetadataManager()->getMetadataFor($class);
  }
  
  /**
   * @param $class
   * @return Domain\RepositoryInterface
   */
  public function getRepositoryFor($class)
  {
    return $this->getRepositoryManager()->getRepositoryFor($class);
  }
  
  /**
   * @return MetadataManager
   */
  public function getMetadataManager()
  {
    return $this->getServiceLocator()->getMetadataManager();
  }
  
  /**
   * @return RepositoryManager
   */
  public function getRepositoryManager()
  {
    return $this->getServiceLocator()->getRepositoryManager();
  }
  
  /**
   * @return ClassManager
   */
  public function getClassManager()
  {
    return $this->getServiceLocator()->getClassManager();
  }
  
  /**
   * @return ServiceLocatorInterface
   */
  public function getServiceLocator(): ServiceLocatorInterface
  {
    return $this->serviceLocator;
  }
  
}