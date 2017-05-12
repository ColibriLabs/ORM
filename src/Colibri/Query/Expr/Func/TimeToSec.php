<?php

namespace Colibri\Query\Expr\Func;

use Colibri\Query\Expr\Func;
use Colibri\Exception\BadCallMethodException;

class TimeToSec extends Func
{

  /**
   * TimeToSec constructor.
   * MySQL Function TIME_TO_SEC
   *
   * @param array $parameters
   * @throws BadCallMethodException
   */
  public function __construct(...$parameters)
  {
    parent::__construct('TIME_TO_SEC', $parameters);
  }
  
}