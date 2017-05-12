<?php

namespace Colibri\Core\Storage;
use Colibri\Core\Entity\EntityInterface;

/**
 * Interface DatabaseStorageInterface
 * @package Colibri\Core\Storage
 */
interface DatabaseStorageInterface
{

  /**
   * @param EntityInterface $entity
   * @return mixed
   */
  public function persist(EntityInterface $entity);

  /**
   * @param $id
   * @return mixed
   */
  public function retrieve($id);

  /**
   * @param $id
   * @return mixed
   */
  public function remove($id);

}