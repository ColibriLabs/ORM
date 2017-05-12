<?php

namespace Colibri\Query\Expr\Func;

use Colibri\Query\Expr\Func;
use Colibri\Exception\BadCallMethodException;

class PeriodAdd extends Func
{

  /**
   * PeriodAdd constructor.
   * MySQL Function PERIOD_ADD
   *
   * @param array $parameters
   * @throws BadCallMethodException
   */
  public function __construct(...$parameters)
  {
    parent::__construct('PERIOD_ADD', $parameters);
  }
  
}