<?php

namespace Colibri\Query\Statement\Comparison;

use Colibri\Exception\BadArgumentException;
use Colibri\Query\Builder\Select;
use Colibri\Query\Expr\Parameters;
use Colibri\Query\Expression;

class In extends Comparison
{
  /**
   * @return string
   * @throws BadArgumentException
   */
  protected function buildCondition()
  {
    $right = $this->stringifyExpression($this->getRightExpression());
    $left = $this->stringifyExpression($this->getLeftExpression());

    return sprintf('%s %s(%s)', $left, $this->getComparator(), $right);
  }

}