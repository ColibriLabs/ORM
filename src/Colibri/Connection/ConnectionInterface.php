<?php

namespace Colibri\Connection;

/**
 * Interface ConnectionInterface
 * @package Colibri\Connection
 */
interface ConnectionInterface
{

  /**
   * @return string
   */
  public function getDriverName();
  
  /**
   * @param $statement
   * @param array $driver_options
   * @return StmtInterface
   */
  public function prepare($statement, $driver_options);
  
  /**
   * @param null $query
   * @param array $params
   * @return StmtInterface
   */
  public function prepareQuery($query = null, array $params);

  /**
   * @param null $query
   * @return ConnectionInterface
   */
  public function execute($query = null);

  /**
   * @param null $query
   * @return StmtInterface
   */
  public function query($query = null);

  /**
   * @return mixed
   */
  public function affectedRows();

  /**
   * @param string $string
   * @return string
   */
  public function clearIdentifier($string);

  /**
   * @param string $string
   * @return string
   */
  public function quoteIdentifier($string);

  /**
   * @param mixed $string
   * @param int $type
   * @return string
   */
  public function escape($string, $type = \PDO::PARAM_STR);

  /**
   * @param $name
   * @return integer|null
   */
  public function lastInsertId($name = null);

  /**
   * @return mixed
   */
  public function start();

  /**
   * @return mixed
   */
  public function commit();

  /**
   * @return mixed
   */
  public function rollback();

  /**
   * @param callable $callback
   * @return mixed
   */
  public function transaction($callback);

}
