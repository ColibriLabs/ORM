<?php

namespace Colibri\Core\Event;

use Colibri\Core\Entity\EntityInterface;
use Colibri\Core\Entity\RepositoryInterface;
use Colibri\EventDispatcher\Event;

/**
 * Class EntityEvent
 *
 * @package Colibri\Core\Event
 */
class EntityEvent extends Event
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
   * EntityEvent constructor.
   *
   * @param EntityInterface     $entity
   * @param RepositoryInterface $repository
   */
  public function __construct(EntityInterface $entity, RepositoryInterface $repository)
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