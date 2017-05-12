<?php

namespace Colibri\Core\Collection;

use Colibri\Core\ActiveRecordInterface;
use Colibri\Core\Entity\EntityInterface;
use Colibri\Core\Entity\RepositoryInterface;

/**
 * Class ActiveEntityCollection
 *
 * @package Colibri\Core\Collection
 */
class ActiveEntityCollection extends EntityCollection implements ActiveRecordInterface
{

  /**
   * @var RepositoryInterface
   */
  protected $repository;

  /**
   * ActiveEntityCollection constructor.
   *
   * @param RepositoryInterface $repository
   * @param array               $data
   */
  public function __construct(RepositoryInterface $repository, array $data)
  {
    parent::__construct($data);
    
    $this->repository = $repository;
  }

  /**
   * @return $this
   */
  public function save()
  {
    $repository = $this->getRepository();
    
    $this->each(function($index, EntityInterface $entity) use ($repository) {
      $repository->persist($entity);
    });

    return $this;
  }

  /**
   * @return $this
   */
  public function delete()
  {
    $repository = $this->getRepository();

    $this->each(function($index, EntityInterface $entity) use ($repository) {
      $repository->remove($entity);
    });

    return $this;
  }
  
  /**
   * @return RepositoryInterface
   */
  public function getRepository()
  {
    return $this->repository;
  }
  
}