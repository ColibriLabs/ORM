<?php

namespace Colibri\Query\Expr\Func;

use Colibri\Query\Expr\Func;
use Colibri\Exception\BadCallMethodException;

class TimeFormat extends Func
{

  /**
   * TimeFormat constructor.
   * MySQL Function TIME_FORMAT
   *
   * @param array $parameters
   * @throws BadCallMethodException
   */
  public function __construct(...$parameters)
  {
    parent::__construct('TIME_FORMAT', $parameters);
  }
  
}