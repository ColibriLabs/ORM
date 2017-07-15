<?php

namespace Colibri\Query\Expr;

use Colibri\Query\Builder\Select;
use Colibri\Query\Expression;

/**
 * Class Subquery
 * @package Colibri\Query\Expr
 */
class Subquery extends Expression
{

  /**
   * @var Select|null
   */
  protected $subquery = null;

  /**
   * Subquery constructor.
   * @param Select $select
   */
  public function __construct(Select $select)
  {
    $this->subquery = $select;
  }

  /**
   * @return string
   */
  public function toSQL()
  {
    return sprintf('(%s)', $this->subquery->toSQL());
  }

  /**
   * @return string
   */
  public function __toString()
  {
    return $this->toSQL();
  }

}
