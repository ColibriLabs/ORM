<?php

namespace Colibri\Query\Expr\Func;

use Colibri\Query\Expr\Func;
use Colibri\Exception\BadCallMethodException;

class Dayofmonth extends Func
{

  /**
   * Dayofmonth constructor.
   * MySQL Function DAYOFMONTH
   *
   * @param array $parameters
   * @throws BadCallMethodException
   */
  public function __construct(...$parameters)
  {
    parent::__construct('DAYOFMONTH', $parameters);
  }
  
}