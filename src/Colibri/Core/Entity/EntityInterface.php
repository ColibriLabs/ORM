<?php

namespace Colibri\Core\Entity;

use Colibri\Collection\Collection;
use Colibri\Common\ArrayableInterface;

/**
 * Interface EntityInterface
 * @package Colibri\Core
 */
interface EntityInterface extends ArrayableInterface, \JsonSerializable
{

  /**
   * @param array $keys
   * @param int $accessLevel
   * @return array
   */
  public function toArray(array $keys = [], $accessLevel = \ReflectionProperty::IS_PUBLIC);

  /**
   * @param $propertyName
   * @return mixed
   */
  public function hasProperty($propertyName);

  /**
   * @param $name
   * @return mixed
   */
  public function hasName($name);

  /**
   * @param $propertyName
   * @param null $default
   * @return mixed
   */
  public function getByProperty($propertyName, $default = null);

  /**
   * @param $propertyName
   * @param $value
   * @return $this
   */
  public function setByProperty($propertyName, $value);

  /**
   * @param $name
   * @param null $default
   * @return mixed
   */
  public function getByName($name, $default = null);

  /**
   * @param $name
   * @param $value
   * @return $this
   */
  public function setByName($name, $value);
  
  /**
   * @param $offset
   * @return mixed
   */
  public function getVirtual($offset);
  
  /**
   * @return Collection
   */
  public function getVirtualColumns();
  
  /**
   * @param $offset
   * @param null $value
   * @return $this
   */
  public function setVirtual($offset, $value = null);
  
  /**
   * @return $this
   */
  public function beforePersist();
  
  /**
   * @return $this
   */
  public function beforeRemove();

}