<?php

namespace Colibri\Core\Storage;

use Colibri\Core\Domain\EntityInterface;

/**
 * Interface RemoverInterface
 * @package Colibri\Core\Storage
 */
interface RemoverInterface
{
  
  /**
   * @param EntityInterface $entity
   * @return $this
   */
  public function remove(EntityInterface $entity);

}