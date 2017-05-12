<?php

namespace Colibri\Query\Statement\Comparison;

use Colibri\Exception\BadCallMethodException;

/**
 * Class RawCondition
 * @package Colibri\Query\Comparison
 */
class Custom extends Comparison
{

  /**
   * @return string
   * @throws BadCallMethodException
   */
  protected function buildCondition()
  {
    throw new BadCallMethodException('Not implemented yet...');
  }

}