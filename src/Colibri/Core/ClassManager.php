<?php

namespace Colibri\Core;

use Colibri\Collection\Collection;
use Colibri\Common\Callback;
use Colibri\Common\ObjectIdentity;
use Colibri\Core\Entity\EntityInterface;
use Colibri\Core\Entity\MetadataInterface;
use Colibri\Core\Entity\RepositoryInterface;
use Colibri\Exception\NotFoundException;
use Colibri\Exception\NotSupportedException;

/**
 * Class ClassManager
 * @package Colibri\Core
 */
class ClassManager
{

  const META_SUFFIX = 'Meta';
  const REPOSITORY_SUFFIX = 'Repository';

  /**
   * @var Collection
   */
  protected $instantiated;

  /**
   * ClassManager constructor.
   */
  public function __construct()
  {
    $this->instantiated = new Collection();
  }

  /**
   * @param $objectName
   * @param bool $returnFactory
   * @return callable|object
   */
  public function getNewInstance($objectName, $returnFactory = false)
  {
    $className = get_class($this->getShared($objectName));

    return $returnFactory ? $this->createInstanceFactoryFor($className) : $this->createInstanceFor($className);
  }

  /**
   * @param $objectName
   * @return mixed|null
   */
  public function getClone($objectName)
  {
    return clone $this->getShared($objectName);
  }

  /**
   * @param $objectName
   * @param $object
   * @return $this
   */
  public function setShared($objectName, $object)
  {
    $this->instantiated->set($objectName, $object);

    return $this;
  }

  /**
   * @param $objectName
   * @return mixed|null
   * @throws NotFoundException
   */
  public function getShared($objectName)
  {
    if ($this->instantiated->has($objectName)) {
      return $this->instantiated->get($objectName);
    }

    throw new NotFoundException('Shared object with name: ":name" was not found', ['name' => $objectName]);
  }

  /**
   * @param $objectName
   * @return bool
   */
  public function hasShared($objectName)
  {
    return $this->instantiated->has($objectName);
  }

  /**
   * @param $class
   * @param array $arguments
   * @return object
   */
  public function createInstanceFor($class, ...$arguments)
  {
    $reflection = new \ReflectionClass($class);

    return $reflection->newInstanceArgs($arguments);
  }

  /**
   * @param $class
   * @return callable
   */
  public function createInstanceFactoryFor($class)
  {
    $callback = new Callback(function (...$arguments) use ($class) {
      return $this->createInstanceFor($class, ...$arguments);
    });

    return $callback;
  }

  /**
   * @param $class
   * @return \ReflectionClass|\ReflectionObject
   */
  public function getReflection($class)
  {
    $isObject = is_object($class);
    $identity = $isObject
      ? ObjectIdentity::createFromObject($class)
      : new ObjectIdentity(sprintf('%s@%s', \ReflectionClass::class, $class));

    if(!$this->hasShared($identity->getIdentifier())) {
      $reflection = $isObject ? new \ReflectionObject($class) : new \ReflectionClass($class);
      $this->setShared($identity->getIdentifier(), $reflection);
    }

    return $this->getShared($identity->getIdentifier());
  }

  /**
   * @param $class
   * @param null|string $remove
   * @param null|string $prepend
   * @return mixed
   */
  public static function transformClassName($class, $remove = null, $prepend = null)
  {
    return sprintf('%s%s', str_replace($remove, null, $class), $prepend);
  }

}