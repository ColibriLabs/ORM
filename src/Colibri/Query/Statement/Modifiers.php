<?php

namespace Colibri\Query\Statement;

use Colibri\Exception\BadArgumentException;
use Colibri\Query\Builder;

/**
 * Class Modifiers
 * @package Colibri\Query\Statement
 */
class Modifiers extends AbstractStatement
{

  /**
   * MySQL Allowed Query Modifiers
   *
   * INSERT Modifiers
   * [LOW_PRIORITY | DELAYED | HIGH_PRIORITY] [IGNORE]
   *
   * DELETE Modifiers
   * [LOW_PRIORITY] [QUICK] [IGNORE]
   *
   * UPDATE Modifiers
   * [LOW_PRIORITY] [IGNORE]
   *
   * SELECT Modifiers
   * [ALL | DISTINCT | DISTINCTROW]
   * [HIGH_PRIORITY]
   * [SQL_SMALL_RESULT] [SQL_BIG_RESULT] [SQL_BUFFER_RESULT]
   * [SQL_CACHE | SQL_NO_CACHE] [SQL_CALC_FOUND_ROWS]
   */

  const LOW_PRIORITY = 1;
  const HIGH_PRIORITY = 2;
  const DELAYED = 4;
  const IGNORE = 8;
  const ALL = 16;
  const DISTINCT = 32;
  const DISTINCTROW = 64;
  const SQL_SMALL_RESULT = 128;
  const SQL_BIG_RESULT = 256;
  const SQL_BUFFER_RESULT = 512;
  const SQL_CACHE = 1024;
  const SQL_NO_CACHE = 2048;
  const SQL_CALC_FOUND_ROWS = 4096;
  const QUICK = 8192;

  const MAP_SELECT = 'SELECT';
  const MAP_INSERT = 'INSERT';
  const MAP_UPDATE = 'UPDATE';
  const MAP_DELETE = 'DELETE';

  /**
   * @var array
   */
  protected static $modifiersNameMap = [
    self::LOW_PRIORITY => 'LOW_PRIORITY',
    self::HIGH_PRIORITY => 'HIGH_PRIORITY',
    self::DELAYED => 'DELAYED',
    self::IGNORE => 'IGNORE',
    self::ALL => 'ALL',
    self::DISTINCT => 'DISTINCT',
    self::DISTINCTROW => 'DISTINCTROW',
    self::SQL_SMALL_RESULT => 'SQL_SMALL_RESULT',
    self::SQL_BIG_RESULT => 'SQL_BIG_RESULT',
    self::SQL_BUFFER_RESULT => 'SQL_BUFFER_RESULT',
    self::SQL_CACHE => 'SQL_CACHE',
    self::SQL_NO_CACHE => 'SQL_NO_CACHE',
    self::SQL_CALC_FOUND_ROWS => 'SQL_CALC_FOUND_ROWS',
    self::QUICK => 'QUICK',
  ];

  /**
   * @var array
   */
  protected static $modifiersMasks = [
    self::MAP_SELECT => (
      self::HIGH_PRIORITY | self::ALL | self::DISTINCT | self::DISTINCTROW |
      self::SQL_SMALL_RESULT | self::SQL_BIG_RESULT | self::SQL_BUFFER_RESULT |
      self::SQL_CACHE | self::SQL_NO_CACHE | self::SQL_CALC_FOUND_ROWS
    ),
    self::MAP_INSERT => (self::LOW_PRIORITY | self::HIGH_PRIORITY | self::DELAYED | self::IGNORE),
    self::MAP_UPDATE => (self::LOW_PRIORITY | self::IGNORE),
    self::MAP_DELETE => (self::LOW_PRIORITY | self::QUICK),
  ];

  /**
   * @var integer
   */
  protected $allowedModifiers = 0;

  /**
   * @var string
   */
  protected $statementName = null;

  /**
   * @var integer
   */
  protected $modifiers = 0;

  /**
   * AbstractStatement constructor.
   * @param Builder $builder
   * @param string $statementName
   * @throws BadArgumentException
   */
  public function __construct(Builder $builder, $statementName = null)
  {
    parent::__construct($builder);

    if (!isset(static::$modifiersMasks[$statementName])) {
      throw new BadArgumentException('Modifiers map-type ":statement_name" could not found in allowed types', [
        'statement_name' => $statementName,
      ]);
    }

    $this->statementName = $statementName;
    $this->allowedModifiers = static::$modifiersMasks[$statementName];
  }

  /**
   * @return array
   */
  public function __debugInfo()
  {
    return [
      'parent_class' => parent::__debugInfo(),
      'statement_name' => $this->statementName,
      'allowed_modifiers' => dechex($this->allowedModifiers),
      'modifiers' => dechex($this->modifiers)
    ];
  }


  /**
   * @param int $modifier
   * @return $this
   */
  public function remove($modifier = 0)
  {
    $this->modifiers &= ~ $modifier;

    return $this;
  }

  /**
   * @param int $modifier
   * @return $this
   */
  public function set($modifier = 0)
  {
    $this->modifiers = $this->resolve($modifier);

    return $this;
  }

  /**
   * @param int $modifier
   * @return $this
   * @throws BadArgumentException
   */
  public function add($modifier = 0)
  {
    $this->modifiers |= $this->resolve($modifier);

    return $this;
  }

  /**
   * @return $this
   */
  public function reset()
  {
    $this->modifiers = 0;

    return $this;
  }

  /**
   * @param integer $modifier
   * @return integer
   * @throws BadArgumentException
   */
  protected function resolve($modifier)
  {
    if ($modifier > 0 && !($modifier & $this->allowedModifiers)) {
      throw new BadArgumentException('Given modifier ":name[0x:bit]" don\'t allowed for this statement ":stmt"', [
        'name' => isset(static::$modifiersNameMap[$modifier]) ? static::$modifiersNameMap[$modifier] : 'UNKNOWN',
        'bit' => dechex($modifier),
        'stmt' => $this->statementName,
      ]);
    }

    return $modifier;
  }

  /**
   * @return string
   */
  public function toSQL()
  {
    if ($this->modifiers > 0) {
      $modifiers = [];

      foreach (static::$modifiersNameMap as $bit => $name) {
        if ($this->modifiers & $bit) {
          $modifiers[] = $name;
        }
      }

      return sprintf(" %s ", implode(' ', $modifiers));
    }

    return null;
  }

}