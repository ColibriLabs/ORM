<?php

namespace Colibri\Query\Expr;

use Colibri\Query\Expression;

/**
 * Class Column
 * @package Colibri\Query\Expr
 */
class Column extends Expression
{

  /**
   * @var string
   */
  protected $database = null;

  /**
   * @var string
   */
  protected $table = null;

  /**
   * @var string
   */
  protected $name = null;

  /**
   * Column constructor.
   * @param string $column
   */
  public function __construct($column)
  {
    $this->parse($column);
  }

  /**
   * @param string $column
   */
  protected function parse($column)
  {
    list($this->database, $this->table, $this->name) = array_pad(explode('.', $column), -3, null);
  }

  /**
   * The __toString method allows a class to decide how it will react when it is converted to a string.
   *
   * @return string
   * @link http://php.net/manual/en/language.oop5.magic.php#language.oop5.magic.tostring
   */
  function __toString()
  {
    return (string) $this->toSQL();
  }

  /**
   * @return string
   */
  public function toSQL()
  {
    return $this->sanitize($this->format());
  }

  /**
   * @return string
   */
  public function format()
  {
    $column = implode('.', array_filter([$this->getDatabase(), $this->getTable(), $this->getName()]));

    return $column;
  }

  /**
   * @return null
   */
  public function getDatabase()
  {
    return $this->database;
  }

  /**
   * @param string $database
   * @return $this
   */
  public function setDatabase($database)
  {
    $this->database = $database;
    return $this;
  }

  /**
   * @return null
   */
  public function getTable()
  {
    return $this->table;
  }

  /**
   * @param string $table
   * @return $this
   */
  public function setTable($table)
  {
    $this->table = $table;
    return $this;
  }

  /**
   * @return null|string
   */
  public function getName()
  {
    return $this->name;
  }

  /**
   * @param string $name
   * @return $this
   */
  public function setName($name)
  {
    $this->name = $name;
    return $this;
  }

  /**
   * @return array
   */
  function __debugInfo()
  {
    return [
      'parent' => parent::__debugInfo(),
      'column' => $this->format(),
    ];
  }

}