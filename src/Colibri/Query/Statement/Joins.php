<?php

namespace Colibri\Query\Statement;

use Colibri\Collection\ArrayCollection;
use Colibri\Query\Builder;
use Colibri\Query\Expression;
use Colibri\Query\Statement\Join\Join;

/**
 * Class Join
 * @package Colibri\Query\Statement
 */
class Joins extends AbstractStatement
{

  const INNER = 'INNER';
  const RIGHT = 'RIGHT';
  const LEFT = 'LEFT';
  const FULL_OUTER = 'FULL OUTER';

  /**
   * @var ArrayCollection|Join[]
   */
  protected $joins = null;

  /**
   * Join constructor.
   * @param Builder $builder
   */
  public function __construct(Builder $builder)
  {
    parent::__construct($builder);

    $this->joins = new ArrayCollection();
  }

  /**
   * @param Expression $foreign
   * @param Where $on
   * @param string $joinType
   * @return $this
   */
  public function add(Expression $foreign, Where $on, $joinType = self::INNER)
  {
    $this->joins->add(new Join($this->getBuilder(), $foreign, $on, $joinType));

    return $this;
  }

  /**
   * @return string
   */
  public function toSQL()
  {
    return $this->joins->exists() ? implode(PHP_EOL, array_map(function(Join $join) {
      return $join->toSQL();
    }, $this->joins->toArray())) : null;
  }

}