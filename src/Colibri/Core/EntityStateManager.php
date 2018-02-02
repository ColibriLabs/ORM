<?php

namespace Colibri\Core;

use Colibri\Core\Domain\EntityInterface;
use Colibri\Core\Domain\RepositoryInterface;
use Colibri\Core\State\AbstractStateManager;
use Colibri\Core\State\State;
use Colibri\Core\State\StateIdentifier;

/**
 * Class EntityStateManager
 * @package Colibri\Core
 */
class EntityStateManager extends AbstractStateManager
{
  
  /**
   * @param EntityInterface $entity
   * @param RepositoryInterface $repository
   * @return $this
   */
  public function lock(EntityInterface $entity, RepositoryInterface $repository)
  {
    return $this->setStateFor(State::LOCKED, $entity, $repository);
  }
  
  /**
   * @param EntityInterface $entity
   * @param RepositoryInterface $repository
   * @return $this
   */
  public function unlock(EntityInterface $entity, RepositoryInterface $repository)
  {
    return $this->setStateFor(State::UNLOCKED, $entity, $repository);
  }
  
  /**
   * @param $state
   * @param EntityInterface $entity
   * @param RepositoryInterface $repository
   * @return $this
   */
  public function setStateFor($state, EntityInterface $entity, RepositoryInterface $repository)
  {
    $state = new State($state, new StateIdentifier($entity), new StateIdentifier($repository));
  
    $this->setState($state);
  
    return $this;
  }
  
}