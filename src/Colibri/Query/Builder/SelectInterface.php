<?php
/**
 * Created by PhpStorm.
 * User: gontarenko
 * Date: 1/4/2018
 * Time: 12:16 PM
 */

namespace Colibri\Query\Builder;

/**
 * Class Select
 * @package Colibri\Query\Builder
 */
interface SelectInterface
{
  
  /**
   * @param string $table
   * @return Select
   */
  public function from($table);
  
  /**
   * @param string $table
   * @return Select
   */
  public function setFromTable($table);
  
  /**
   * @param array $columns
   * @return Select
   */
  public function addSelectColumns(array $columns);
  
  /**
   * @param string $expression
   * @param null $alias
   * @return $this
   */
  public function addSelectColumn($expression, $alias = null);
  
  /**
   * @return $this
   */
  public function clearSelectColumns();
  
  /**
   * @param string $column
   * @param string $alias
   * @return Select
   */
  public function avg($column, $alias);
  
  /**
   * @param $column
   * @param $alias
   * @return Select
   */
  public function count($column, $alias);
  
  /**
   * @param $column
   * @param $alias
   * @return Select
   */
  public function max($column, $alias);
  
  /**
   * @param $column
   * @param $alias
   * @return Select
   */
  public function min($column, $alias);
}