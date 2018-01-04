<?php

namespace Colibri\Query\Builder\Common;

use Colibri\Query\Builder\SelectInterface;

/**
 * Trait SelectTrait
 * @package Colibri\Query\Builder\Common
 */
trait SelectTrait
{
  
  /**
   * @inheritDoc
   */
  public function from($table)
  {
    $this->getSelectBuilderObject()->from($table);
    
    return $this;
  }
  
  /**
   * @inheritDoc
   */
  public function setFromTable($table)
  {
    $this->getSelectBuilderObject()->setFromTable($table);
  
    return $this;
  }
  
  /**
   * @inheritDoc
   */
  public function addSelectColumns(array $columns)
  {
    $this->getSelectBuilderObject()->addSelectColumns($columns);
  
    return $this;
  }
  
  /**
   * @inheritDoc
   */
  public function addSelectColumn($expression, $alias = null)
  {
    $this->getSelectBuilderObject()->addSelectColumn($expression, $alias);
  
    return $this;
  }
  
  /**
   * @inheritDoc
   */
  public function clearSelectColumns()
  {
    $this->getSelectBuilderObject()->clearSelectColumns();
  
    return $this;
  }
  
  /**
   * @inheritDoc
   */
  public function avg($column, $alias)
  {
    $this->getSelectBuilderObject()->avg($column, $alias);
  
    return $this;
  }
  
  /**
   * @inheritDoc
   */
  public function count($column, $alias)
  {
    $this->getSelectBuilderObject()->count($column, $alias);
  
    return $this;
  }
  
  /**
   * @inheritDoc
   */
  public function max($column, $alias)
  {
    $this->getSelectBuilderObject()->max($column, $alias);
  
    return $this;
  }
  
  /**
   * @inheritDoc
   */
  public function min($column, $alias)
  {
    $this->getSelectBuilderObject()->min($column, $alias);
  
    return $this;
  }
  
  /**
   * @return SelectInterface
   */
  abstract public function getSelectBuilderObject();
  
}