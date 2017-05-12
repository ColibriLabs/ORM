<?php

namespace Colibri\Collection;

/**
 * Interface CollectionInterface
 * @package Colibri\Collection
 */
interface CollectionInterface extends \ArrayAccess, \IteratorAggregate, \Countable, \JsonSerializable, \Serializable
{

  /**
   * @param $key
   * @return mixed
   */
  public function has($key);

  /**
   * @param $element
   * @return boolean
   */
  public function contains($element);
  
  /**
   * @param $element
   * @return integer
   */
  public function indexOf($element);
  
  /**
   * @param $key
   * @param null $default
   * @return mixed
   */
  public function get($key, $default = null);

  /**
   * @param array $keys
   * @return array
   */
  public function all(array $keys = []);

  /**
   * @param array $elements
   * @return $this
   */
  public function batch(array $elements);

  /**
   * @param $offset
   * @param $element
   * @return $this
   */
  public function set($offset, $element);

  /**
   * @param $element
   * @return $this
   */
  public function add($element);
  
  /**
   * @param $element
   * @return $this
   */
  public function append($element);
  
  /**
   * @param $element
   * @return $this
   */
  public function prepend($element);
  
  /**
   * @param $key
   * @return mixed
   */
  public function remove($key);

  /**
   * @param \Closure $closure
   * @param array $context
   * @return $this
   */
  public function map(\Closure $closure, array $context = []);

  /**
   * @param \Closure $closure
   * @return $this
   */
  public function each(\Closure $closure);

  /**
   * @param \Closure $closure
   * @return $this
   */
  public function filter(\Closure $closure);

  /**
   * @param \Closure $closure
   * @return $this
   */
  public function sort(\Closure $closure);

  /**
   * @return boolean
   */
  public function exists();
  
  /**
   * @return boolean
   */
  public function isEmpty();
  
  /**
   * @return boolean
   */
  public function isNotEmpty();

  /**
   * @return $this
   */
  public function clear();

  /**
   * @return object
   */
  public function toObject();

  /**
   * @return array
   */
  public function toArray();

  /**
   * @return string
   */
  public function toJSON();

}