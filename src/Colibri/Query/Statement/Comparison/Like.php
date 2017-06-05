<?php

namespace Colibri\Query\Statement\Comparison;

use Colibri\Exception\BadArgumentException;

/**
 * Class Like
 * @package Colibri\Query\Statement\Comparison
 */
class Like extends Comparison
{

  /**
   * @return string
   * @throws BadArgumentException
   */
  protected function buildCondition()
  {
    return sprintf('%s %s %s',
      $this->stringifyExpression($this->getLeftExpression()),
      $this->getComparator(),
      $this->stringifyExpression($this->getRightExpression())
    );
  }

}
