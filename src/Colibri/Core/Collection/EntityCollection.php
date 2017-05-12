<?php

namespace Colibri\Core\Collection;

use Colibri\Collection\Collection;
use Colibri\Collection\CollectionInterface;
use Colibri\Core\Entity\EntityInterface;

/**
 * Class EntityCollection
 * @package Colibri\Core\Collection
 */
class EntityCollection extends Collection
{

  /**
   * EntityCollection constructor.
   * @param array $data
   */
  public function __construct(array $data)
  {
    parent::__construct($data, EntityInterface::class);
  }

  /**
   * @param $keyName
   * @param $valueKey
   * @return Collection
   */
  public function dictionary($keyName, $valueKey)
  {
    $collection = [];

    $this->each(function($index, EntityInterface $entity) use ($keyName, $valueKey, &$collection) {
      $collection[$entity->getByName($keyName)] = $entity->getByName($valueKey);
    });

    return new Collection($collection);
  }

  /**
   * @param $name
   * @return Collection
   */
  public function values($name)
  {
    return $this->map(function (EntityInterface $entity) use ($name) {
      return $entity->getByName($name);
    });
  }

  /**
   * @param $propertyName
   * @return Collection
   */
  public function propertyValues($propertyName)
  {
    return $this->map(function (EntityInterface $entity) use ($propertyName) {
      return $entity->getByProperty($propertyName);
    });
  }

  /**
   * @param $name
   * @param $value
   * @return EntityCollection
   */
  public function filterValues($name, $value)
  {
    return $this->filter(function (EntityInterface $entity) use ($name, $value) {
      return $entity->getByName($name) === $value;
    });
  }

  /**
   * @param \Closure $closure
   * @return EntityCollection
   */
  public function filter(\Closure $closure)
  {
    return new EntityCollection(parent::filter($closure)->toArray());
  }

  /**
   * @inheritDoc
   */
  public function toArray()
  {
    $collection = [];

    /** @var CollectionInterface|EntityInterface $entity */
    foreach ($this as $name => $entity) {
      $collection[$name] = $entity->toArray();
    }

    return $collection;
  }

}
