<?php

namespace Colibri\Query\Statement\Comparison;

use Colibri\Exception\BadArgumentException;

class Like extends Comparison
{

  /**
   * @return string
   * @throws BadArgumentException
   */
  protected function buildCondition()
  {
    if (!is_scalar($this->getRightExpression())) {
      throw new BadArgumentException('Bad value type for ":class" string expect ":type" given', [
        'class' => __CLASS__,
        'type' => gettype($this->getRightExpression()),
      ]);
    }

    return sprintf('%s %s %s', $this->stringifyExpression(), $this->getComparator(), $this->getRightExpression());
  }

}