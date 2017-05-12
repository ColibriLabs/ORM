<?php

namespace Colibri\Query\Builder\Syntax;

use Colibri\Exception\BadArgumentException;
use Colibri\Query\Expression;
use Colibri\Query\Statement\OrderBy;
use Colibri\Query\Expr;

/**
 * Class OrderByTrait
 * @package Colibri\Query\Builder\Syntax
 */
trait OrderByTrait
{

  /**
   * @return OrderBy
   * @throws BadArgumentException
   */
  abstract public function getOrderByStatement();

  /**
   * @param $expression
   * @param string $vector
   * @return $this
   */
  public function orderBy($expression, $vector = OrderBy::ASC)
  {
    $expression = ($expression instanceof Expression) ? $expression : new Expr\Column($expression);
    $this->getOrderByStatement()->order($expression, $vector);

    return $this;
  }

  /**
   * @param $column
   * @return $this
   */
  public function orderByAsc($column)
  {
    return $this->orderBy($column, OrderBy::ASC);
  }

  /**
   * @param $column
   * @return $this
   */
  public function orderByDesc($column)
  {
    return $this->orderBy($column, OrderBy::DESC);
  }

  /**
   * @param $column
   * @return $this
   */
  public function asc($column)
  {
    return $this->orderByAsc($column);
  }

  /**
   * @param $column
   * @return $this
   */
  public function desc($column)
  {
    return $this->orderByDesc($column);
  }

  /**
   * @return $this
   */
  public function orderRandom()
  {
    return $this->orderBy(new Expr\Func('RAND'), null);
  }

}