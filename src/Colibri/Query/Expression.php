<?php

namespace Colibri\Query;

use Colibri\Exception\NullPointerException;

/**
 * Class Expression
 * @package Colibri\Query
 */
abstract class Expression implements SqlableInterface
{

  /**
   * @var Builder
   */
  protected $builder = null;

  /**
   * @return Builder
   * @throws NullPointerException
   */
  public function getBuilder()
  {
    if(null === $this->builder) {
      throw new NullPointerException('Expression ":class" should have injected builder object', [
        'class' => static::class,
      ]);
    }

    return $this->builder;
  }

  /**
   * @param $identifier
   * @return string
   */
  protected function sanitize($identifier)
  {
    return $this->getBuilder()->quoteIdentifier($identifier);
  }

  /**
   * @param $value
   * @param int $type
   * @return string
   */
  protected function escape($value, $type = \PDO::PARAM_STR)
  {
    return $this->getBuilder()->getConnection()->escape($value, $type);
  }

  /**
   * @param Builder $builder
   * @return $this
   */
  public function setBuilder(Builder $builder)
  {
    $this->builder = $builder;

    return $this;
  }

  /**
   * @return string
   */
  public function hashCode()
  {
    return sprintf('%s:%s', static::class, substr(sha1(spl_object_hash($this)), 0, 8));
  }

  /**
   * This method is called by var_dump() when dumping an object to get the properties that should be shown.
   * If the method isn't defined on an object, then all public, protected and private properties will be shown.
   * @since PHP 5.6.0
   *
   * @return array
   * @link http://php.net/manual/en/language.oop5.magic.php#language.oop5.magic.debuginfo
   */
  function __debugInfo()
  {
    return [
      'expression_class' => static::class,
      'hash_code' => $this->hashCode(),
      'has_builder' => (null !== $this->builder)
    ];
  }


  /**
   * @return string
   */
  abstract public function __toString();

}