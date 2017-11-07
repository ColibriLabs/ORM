<?php

namespace Colibri\Query\Statement;

use Colibri\Collection\Collection;
use Colibri\Exception\BadArgumentException;
use Colibri\Query\Builder;
use Colibri\Query\Expr;
use Colibri\Query\Expression;

/**
 * Class OrderBy
 * @package Colibri\Query\Statement
 */
class OrderBy extends AbstractStatement
{
  
  use Builder\Syntax\OrderByTrait;

  const ASC = 'ASC';
  const DESC = 'DESC';

  /**
   * @var Collection|null
   */
  protected $expressions;

  /**
   * OrderBy constructor.
   * @param Builder $builder
   */
  public function __construct(Builder $builder)
  {
    parent::__construct($builder);

    $this->expressions = new Collection();
  }
  
  /**
   * @inheritdoc
   */
  public function __clone()
  {
    $this->expressions = clone $this->expressions;
  }
  
  /**
   * @return Collection
   */
  public function getExpressions()
  {
    return $this->expressions;
  }
  
  /**
   * @param Expression $expression
   * @param string $vector
   * @return $this
   */
  public function order(Expression $expression, $vector = OrderBy::ASC)
  {
    $this->expressions[] = ['expression' => $expression, 'vector' => $vector,];

    return $this;
  }

  /**
   * @return string
   */
  public function toSQL()
  {
    return $this->expressions->exists() ? implode(', ', array_map(function(array $definition) {
      $vector = $definition['vector'];
      $expression = $this->stringifyExpression($definition['expression']);
      return null === $vector
        ? $expression : sprintf('%s %s', $expression, $vector);
    }, $this->expressions->toArray())) : null;
  }
  
  /**
   * @inheritDoc
   */
  public function getOrderByStatement()
  {
    return $this;
  }
  
}
