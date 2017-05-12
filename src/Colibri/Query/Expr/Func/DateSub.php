<?php

namespace Colibri\Query\Expr\Func;

use Colibri\Query\Expr\Func;
use Colibri\Exception\BadCallMethodException;

class DateSub extends Func
{

  /**
   * DateSub constructor.
   * MySQL Function DATE_SUB
   *
   * @param array $parameters
   * @throws BadCallMethodException
   */
  public function __construct(...$parameters)
  {
    parent::__construct('DATE_SUB', $parameters);
  }
  
}