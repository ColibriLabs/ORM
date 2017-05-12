<?php

namespace Colibri\Core\Event;

use Colibri\Core\Entity\EntityInterface;
use Colibri\Core\Entity\RepositoryInterface;
use Colibri\EventDispatcher\Event;

/**
 * Class EntityLifecycleEvent
 * @package Colibri\Core\Event
 */
class EntityLifecycleEvent extends Event
{
  
  /**
   * @var EntityInterface
   */
  protected $entity;
  
  /**
   * @var RepositoryInterface
   */
  protected $repository;
  
  /**
   * EntityLifecycleEvent constructor.
   * @param RepositoryInterface $repository
   * @param EntityInterface $entity
   */
  public function __construct(RepositoryInterface $repository, EntityInterface $entity)
  {
    $this->entity = $entity;
    $this->repository = $repository;
  }
  
  /**
   * @return EntityInterface
   */
  public function getEntity()
  {
    return $this->entity;
  }
  
  /**
   * @return RepositoryInterface
   */
  public function getRepository()
  {
    return $this->repository;
  }
  
}