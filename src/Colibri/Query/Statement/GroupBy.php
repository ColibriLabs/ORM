<?php

namespace Colibri\Query\Statement;

use Colibri\Exception\BadArgumentException;
use Colibri\Logger\Collection\Collection;
use Colibri\Query\Builder;
use Colibri\Query\Builder\Syntax;
use Colibri\Query\Expr\Column;
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
  protected $expressions = null;

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

    $this->expressions = new Collection();
  }
  
  /**
   * @return Collection
   */
  public function getExpressions()
  {
    return $this->expressions;
  }
  
  /**
   * @param array ...$columns
   * @return $this
   */
  public function add(...$columns)
  {
    foreach ($columns as $column) {
      $this->addGroupBy($column);
    }

    return $this;
  }

  /**
   * @param $expression
   * @return $this
   */
  public function addGroupBy($expression)
  {
    if(!($expression instanceof Expression)) {
      $expression = new Column($expression);
    }

    $this->expressions->set($expression->hashCode(), $expression);

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
    return $this->expressions->exists()
      ? trim(sprintf("%s %s", implode(', ', array_map(function(Expression $expression) {
        return $this->stringifyExpression($expression);
      }, $this->expressions->toArray())), ($this->withRollup ? 'WITH ROLLUP' : null))) : null;
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
