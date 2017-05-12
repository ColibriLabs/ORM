<?php

namespace  Colibri\Query\Builder\Syntax;

use Colibri\Exception\BadArgumentException;
use Colibri\Query\Statement\GroupBy;

/**
 * Class GroupByTrait
 * @package Colibri\Query\Builder
 */
trait GroupByTrait
{

  /**
   * @return GroupBy
   * @throws BadArgumentException
   */
  abstract public function getGroupByStatement();

  /**
   * @param array $columns
   * @return $this
   * @throws BadArgumentException
   */
  public function groupBy(...$columns)
  {
    $this->getGroupByStatement()->add(...$columns);

    return $this;
  }

  /**
   * @return $this
   */
  public function enableWithRollup()
  {
    $this->getGroupByStatement()->withRollup(true);

    return $this;
  }

  /**
   * @return $this
   */
  public function disableWithRollup()
  {
    $this->getGroupByStatement()->withRollup(false);

    return $this;
  }

}