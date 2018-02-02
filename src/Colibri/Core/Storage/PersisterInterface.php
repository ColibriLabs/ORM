<?php

namespace Colibri\Core\Storage;

use Colibri\Core\Domain\EntityInterface;

/**
 * Interface PersisterInterface
 * @package Colibri\Core\Storage
 */
interface PersisterInterface
{
  
  /**
   * @param EntityInterface $entity
   * @return $this
   */
  public function create(EntityInterface $entity);
  
  /**
   * @param EntityInterface $entity
   * @return $this
   */
  public function update(EntityInterface $entity);
  
  /**
   * @param EntityInterface $entity
   * @return $this
   */
  public function remove(EntityInterface $entity);
  
}