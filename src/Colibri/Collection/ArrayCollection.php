<?php

namespace Colibri\Collection;

use Colibri\Exception\NotSupportedException;

/**
 * Class ArrayCollection
 * @package Colibri\Collection
 */
class ArrayCollection implements CollectionInterface
{
  
  /**
   * @var array
   */
  protected $storage = [];
  
  /**
   * @var string
   */
  protected $className;
  
  /**
   * AbstractCollection constructor.
   * @param array $data
   * @param null|string $className
   * @throws NotSupportedException
   */
  public function __construct(array $data = [], $className = null)
  {
    $this->className = $className;
    $this->batch($data);
  }
  
  /**
   * @inheritDoc
   */
  public function batch(array $data)
  {
    foreach ($data as $key => $value) {
      $this->set($key, $value);
    }
    
    return $this;
  }
  
  /**
   * @inheritDoc
   */
  public function has($offset)
  {
    return array_key_exists($offset, $this->storage);
  }
  
  /**
   * @inheritDoc
   */
  public function get($offset, $default = null)
  {
    return $this->has($offset) ? $this->storage[$offset] : $default;
  }
  
  /**
   * @inheritDoc
   */
  public function all(array $keys = [])
  {
    return empty($keys) ? $this->storage : array_intersect_key($this->storage, array_flip($keys));
  }
  
  /**
   * @inheritDoc
   */
  public function set($offset = null, $data)
  {
    $this->storage[$offset] = $data;
    
    return $this;
  }
  
  /**
   * @inheritDoc
   */
  public function add($data)
  {
    $this->storage[] = $data;
    
    return $this;
  }
  
  /**
   * @inheritDoc
   */
  public function append($element)
  {
    array_push($this->storage, $element);
    
    return $this;
  }
  
  /**
   * @inheritDoc
   */
  public function prepend($element)
  {
    array_unshift($this->storage, $element);
    
    return $this;
  }
  
  /**
   * @inheritDoc
   */
  public function contains($element)
  {
    return in_array($element, $this->all());
  }
  
  /**
   * @inheritDoc
   */
  public function indexOf($element)
  {
    return array_search($element, $this->all());
  }
  
  /**
   * @inheritDoc
   */
  public function remove($key)
  {
    unset($this->storage[$key]);
    
    return $this;
  }
  
  /**
   * @inheritDoc
   */
  public function keys()
  {
    return array_keys($this->storage);
  }
  
  /**
   * @inheritDoc
   */
  public function map(\Closure $closure, array $context = [])
  {
    $collection = new ArrayCollection();
    
    $this->each(function ($key, $data) use ($collection, $closure, $context) {
      $collection->set($key, $closure($data, $context));
    });
    
    return $collection;
  }
  
  /**
   * @inheritDoc
   */
  public function filter(\Closure $closure)
  {
    $elements = [];
    
    $this->each(function ($key, $element) use (&$elements, $closure) {
      if ($closure($element, $key)) {
        $elements[$key] = $element;
      }
    });
    
    return new ArrayCollection($elements);
  }
  
  /**
   * @inheritDoc
   */
  public function each(\Closure $closure)
  {
    foreach ($this as $key => $data) {
      $closure($key, $data);
    }
    
    return $this;
  }
  
  /**
   * @inheritDoc
   */
  public function sort(\Closure $closure)
  {
    usort($this->storage, $closure);
    
    return $this;
  }
  
  /**
   * @inheritDoc
   */
  public function exists()
  {
    return $this->count() > 0;
  }
  
  /**
   * @inheritDoc
   */
  public function isEmpty()
  {
    return !$this->isNotEmpty();
  }
  
  /**
   * @inheritDoc
   */
  public function isNotEmpty()
  {
    return $this->exists();
  }
  
  /**
   * @inheritDoc
   */
  public function clear()
  {
    $this->storage = [];
    
    return $this;
  }
  
  /**
   * @inheritDoc
   */
  public function toObject()
  {
    $objectData = new \stdClass();
    
    foreach ($this as $key => $data) {
      $objectData->{$key} = ($data instanceof CollectionInterface)
        ? $data->toObject()
        : $data;
    }
    
    return $objectData;
  }
  
  /**
   * @inheritDoc
   */
  public function toArray()
  {
    $arrayData = [];
    
    foreach ($this as $key => $data) {
      $arrayData[$key] = ($data instanceof CollectionInterface) ? $data->toArray() : $data;
    }
    
    return $arrayData;
  }
  
  /**
   * @inheritDoc
   */
  public function toJSON()
  {
    return json_encode($this);
  }
  
  /**
   * @inheritDoc
   */
  public function getIterator()
  {
    return new \ArrayIterator($this->storage);
  }
  
  /**
   * @inheritDoc
   */
  public function offsetExists($offset)
  {
    return $this->has($offset);
  }
  
  /**
   * @inheritDoc
   */
  public function offsetGet($offset)
  {
    return $this->get($offset, null);
  }
  
  /**
   * @inheritDoc
   */
  public function offsetSet($offset, $data)
  {
    null === $offset ? $this->add($data) : $this->set($offset, $data);
  }
  
  /**
   * @inheritDoc
   */
  public function offsetUnset($offset)
  {
    $this->remove($offset);
  }
  
  /**
   * @inheritDoc
   */
  public function count()
  {
    return count($this->storage);
  }
  
  /**
   * @inheritDoc
   */
  function jsonSerialize()
  {
    return $this->toArray();
  }
  
  /**
   * @inheritDoc
   */
  public function serialize()
  {
    return serialize($this->toArray());
  }
  
  /**
   * @inheritDoc
   */
  public function unserialize($serialized)
  {
    $this->batch(unserialize($serialized));
  }
  
}
