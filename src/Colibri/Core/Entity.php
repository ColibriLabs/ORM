<?php

namespace Colibri\Core;

use Colibri\Collection\Collection;
use Colibri\Common\Inflector;
use Colibri\Core\Entity\EntityInterface;

/**
 * Class Entity
 * @package Colibri\Core\Entity
 */
abstract class Entity implements EntityInterface
{
  
  protected $virtual;

  /**
   * Entity constructor.
   */
  public function __construct()
  {
    $this->virtual = new Collection();
  }
  
  /**
   * @param array $keys
   * @param int $accessLevel
   * @param bool $underscoreKeys
   * @return array
   */
  public function toArray(array $keys = [], $accessLevel = \ReflectionProperty::IS_PUBLIC, $underscoreKeys = false)
  {
    $collection = [];
    $reflection = new \ReflectionObject($this);

    foreach($reflection->getProperties($accessLevel) as $property) {
      
      if (empty($keys) || in_array($property->getName(), $keys, true)) {
        
        $propertyValue = $property->getValue($this);
        $propertyName = $underscoreKeys ? Inflector::underscore($property->getName()) : $property->getName();
        
        $collection[$propertyName] = ($propertyValue instanceof EntityInterface)
          ? $propertyValue->toArray([], $accessLevel) : $propertyValue;
        
      }
    }

    return $collection;
  }

  /**
   * @return array
   */
  function jsonSerialize()
  {
    return $this->toArray();
  }

  /**
   * @inheritDoc
   */
  public function hasProperty($propertyName)
  {
    return property_exists($this, $propertyName);
  }

  /**
   * @inheritDoc
   */
  public function hasName($name)
  {
    return $this->hasProperty(Inflector::camelize($name));
  }

  /**
   * @inheritDoc
   */
  public function getByProperty($propertyName, $default = null)
  {
    return $this->hasProperty($propertyName) ? $this->$propertyName : $default;
  }

  /**
   * @inheritDoc
   */
  public function setByProperty($propertyName, $value)
  {
    if ($this->hasProperty($propertyName)) {
      $this->$propertyName = $value;
    }

    return $this;
  }

  /**
   * @inheritDoc
   */
  public function getByName($name, $default = null)
  {
    return $this->getByProperty(Inflector::camelize($name), $default);
  }

  /**
   * @inheritDoc
   */
  public function setByName($name, $value)
  {
    return $this->setByProperty(Inflector::camelize($name), $value);
  }
  
  /**
   * @inheritDoc
   */
  public function getVirtual($offset)
  {
    return $this->virtual->get($offset);
  }
  
  /**
   * @inheritDoc
   */
  public function getVirtualColumns()
  {
    return $this->virtual;
  }
  
  /**
   * @inheritDoc
   */
  public function setVirtual($offset, $value = null)
  {
    $this->virtual->set($offset, $value);
    
    return $this;
  }
  
  /**
   * @inheritdoc
   */
  public function hashCode()
  {
    return sha1(json_encode($this->toArray()));
  }
  
  /**
   * @inheritDoc
   */
  public function beforePersist()
  {
    
  }
  
  /**
   * @inheritDoc
   */
  public function beforeRemove()
  {
    
  }
  
}
