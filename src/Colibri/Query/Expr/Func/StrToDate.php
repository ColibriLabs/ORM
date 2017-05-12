<?php

namespace Colibri\Query\Expr\Func;

use Colibri\Query\Expr\Func;
use Colibri\Exception\BadCallMethodException;

class StrToDate extends Func
{

  /**
   * StrToDate constructor.
   * MySQL Function STR_TO_DATE
   *
   * @param array $parameters
   * @throws BadCallMethodException
   */
  public function __construct(...$parameters)
  {
    parent::__construct('STR_TO_DATE', $parameters);
  }
  
}