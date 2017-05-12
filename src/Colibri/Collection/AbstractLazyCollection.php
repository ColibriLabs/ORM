<?php

namespace Colibri\Collection;

use Colibri\Core\ProxyInterface;

/**
 * Class AbstractLazyCollection
 * @package Colibri\Collection
 */
abstract class AbstractLazyCollection implements CollectionInterface, ProxyInterface
{
  
  /**
   * @var CollectionInterface
   */
  protected $collection;
  
  /**
   * @var bool
   */
  protected $isInitialized = false;
  
  /**
   * @inheritDoc
   */
  public function has($key)
  {
    return $this->initialize()->collection->has($key);
  }
  
  /**
   * @inheritDoc
   */
  public function contains($element)
  {
    return $this->initialize()->collection->contains($element);
  }
  
  /**
   * @inheritDoc
   */
  public function indexOf($element)
  {
    return $this->initialize()->collection->indexOf($element);
  }
  
  /**
   * @inheritDoc
   */
  public function get($key, $default = null)
  {
    return $this->initialize()->collection->get($key, $default);
  }
  
  /**
   * @inheritDoc
   */
  public function all(array $keys = [])
  {
    return $this->initialize()->collection->all($keys);
  }
  
  /**
   * @inheritDoc
   */
  public function batch(array $elements)
  {
    return $this->initialize()->collection->batch($elements);
  }
  
  /**
   * @inheritDoc
   */
  public function set($offset, $element)
  {
    return $this->initialize()->collection->set($offset, $element);
  }
  
  /**
   * @inheritDoc
   */
  public function add($element)
  {
    return $this->initialize()->collection->add($element);
  }
  
  /**
   * @inheritDoc
   */
  public function append($element)
  {
    return $this->initialize()->collection->append($element);
  }
  
  /**
   * @inheritDoc
   */
  public function prepend($element)
  {
    return $this->initialize()->collection->prepend($element);
  }
  
  /**
   * @inheritDoc
   */
  public function remove($key)
  {
    return $this->initialize()->collection->remove($key);
  }
  
  /**
   * @inheritDoc
   */
  public function map(\Closure $closure, array $context = [])
  {
    return $this->initialize()->collection->map($closure, $context);
  }
  
  /**
   * @inheritDoc
   */
  public function each(\Closure $closure)
  {
    return $this->initialize()->collection->map($closure);
  }
  
  /**
   * @inheritDoc
   */
  public function filter(\Closure $closure)
  {
    return $this->initialize()->collection->filter($closure);
  }
  
  /**
   * @inheritDoc
   */
  public function sort(\Closure $closure)
  {
    return $this->initialize()->collection->sort($closure);
  }
  
  /**
   * @inheritDoc
   */
  public function exists()
  {
    return $this->initialize()->collection->exists();
  }
  
  /**
   * @inheritDoc
   */
  public function isEmpty()
  {
    return $this->initialize()->collection->isEmpty();
  }
  
  /**
   * @inheritDoc
   */
  public function isNotEmpty()
  {
    return $this->initialize()->collection->isNotEmpty();
  }
  
  /**
   * @inheritDoc
   */
  public function clear()
  {
    return $this->initialize()->collection->clear();
  }
  
  /**
   * @inheritDoc
   */
  public function toObject()
  {
    return $this->initialize()->collection->toObject();
  }
  
  /**
   * @inheritDoc
   */
  public function toArray()
  {
    return $this->initialize()->collection->toArray();
  }
  
  /**
   * @inheritDoc
   */
  public function toJSON()
  {
    return $this->initialize()->collection->toJSON();
  }
  
  /**
   * @inheritDoc
   */
  public function getIterator()
  {
    return $this->initialize()->collection->getIterator();
  }
  
  /**
   * @inheritDoc
   */
  public function offsetExists($offset)
  {
    return $this->initialize()->collection->offsetExists($offset);
  }
  
  /**
   * @inheritDoc
   */
  public function offsetGet($offset)
  {
    return $this->initialize()->collection->offsetGet($offset);
  }
  
  /**
   * @inheritDoc
   */
  public function offsetSet($offset, $value)
  {
    return $this->initialize()->collection->offsetSet($offset, $value);
  }
  
  /**
   * @inheritDoc
   */
  public function offsetUnset($offset)
  {
    return $this->initialize()->collection->offsetUnset($offset);
  }
  
  /**
   * @inheritDoc
   */
  public function serialize()
  {
    return $this->initialize()->collection->serialize();
  }
  
  /**
   * @inheritDoc
   */
  public function unserialize($serialized)
  {
    return $this->initialize()->collection->unserialize($serialized);
  }
  
  /**
   * @inheritDoc
   */
  public function count()
  {
    return $this->initialize()->collection->count();
  }
  
  /**
   * @inheritDoc
   */
  function jsonSerialize()
  {
    return $this->initialize()->collection->jsonSerialize();
  }
  
  /**
   * @inheritDoc
   */
  public function initialize()
  {
    if (!$this->isInitialized()) {
      $this->doInitialize();
      $this->isInitialized = true;
    }
    
    return $this;
  }
  
  /**
   * @inheritDoc
   */
  public function isInitialized()
  {
    return $this->isInitialized;
  }
  
  /**
   * @return void
   */
  abstract protected function doInitialize();
  
}