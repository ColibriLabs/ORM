<?php

namespace Colibri\Query;

use Colibri\Exception\BadCallMethodException;
use Colibri\Query\Builder\Delete;
use Colibri\Query\Builder\Select;
use Colibri\ServiceContainer\ServiceLocator;

/**
 * Class BuilderFactory
 * @package Colibri\Query
 */
final class Factory
{

  /**
   * @param $table
   * @return Select
   */
  public static function select($table)
  {
    return (new Select(ServiceLocator::instance()->getConnection()))->from($table);
  }

  /**
   * @param $table
   * @return Builder
   */
  public static function update($table)
  {
    return null;
  }

  /**
   * @param $table
   * @return Builder
   */
  public static function insert($table)
  {
    return null;
  }

  /**
   * @param $table
   * @return Delete
   */
  public static function delete($table)
  {
    return null;
  }

  /**
   * BuilderFactory constructor.
   */
  public function __construct()
  {
    $this->throwException();
  }

  /**
   * BuilderFactory wake up.
   */
  function __wakeup()
  {
    $this->throwException();
  }

  /**
   * BuilderFactory clone method
   */
  function __clone()
  {
    $this->throwException();
  }

  /**
   * @throws BadCallMethodException
   */
  private function throwException()
  {
    throw new BadCallMethodException('Instantiate object of class ":class" disallowed. Only statically calling methods', [
      'class' => __CLASS__,
    ]);
  }

}