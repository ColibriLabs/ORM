<?php

namespace Colibri\Query\Statement;

use Colibri\Exception\BadArgumentException;
use Colibri\Logger\Collection\Collection;
use Colibri\Query\Builder;
use Colibri\Query\Builder\Syntax;
use Colibri\Query\Expression;

/**
 * Class GroupBy
 * @package Colibri\Query\Statement
 */
class GroupBy extends AbstractStatement
{

  use Syntax\GroupByTrait;

  /**
   * @var Collection|null
   */
  protected $map = null;

  /**
   * @var bool
   */
  protected $withRollup = false;

  /**
   * GroupStatement constructor.
   * @param Builder $builder
   */
  public function __construct(Builder $builder)
  {
    parent::__construct($builder);

    $this->map = new Collection();
  }

  /**
   * @param array ...$columns
   * @return $this
   */
  public function add(...$columns)
  {
    foreach ($columns as $column) {
      $this->addGroupBy(...(is_array($column) ? $column : [$column]));
    }

    return $this;
  }

  /**
   * @param $expression
   * @param null $alias
   * @return $this
   */
  public function addGroupBy($expression, $alias = null)
  {
    if($expression instanceof Expression) {
      $this->registerExpression($expression, $alias);
    } else {
      $expression = $this->getBuilder()->createColumn($expression, $alias);
    }

    $this->map->set($expression->hashCode(), $expression);

    return $this;
  }

  /**
   * @param bool $use
   * @return $this
   */
  public function withRollup($use = false)
  {
    $this->withRollup = $use;

    return $this;
  }

  /**
   * @return string
   */
  public function toSQL()
  {
    return $this->map->exists()
      ? trim(sprintf("%s %s", implode(', ', array_map(function(Expression $expression) {
        return $this->stringifyExpression($expression);
      }, $this->map->toArray())), ($this->withRollup ? 'WITH ROLLUP' : null))) : null;
  }

  /**
   * @return GroupBy
   * @throws BadArgumentException
   */
  public function getGroupByStatement()
  {
    return $this;
  }

}