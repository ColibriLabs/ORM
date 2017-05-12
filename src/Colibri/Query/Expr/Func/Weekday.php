<?php

namespace Colibri\Query\Expr\Func;

use Colibri\Query\Expr\Func;
use Colibri\Exception\BadCallMethodException;

class Weekday extends Func
{

  /**
   * Weekday constructor.
   * MySQL Function WEEKDAY
   *
   * @param array $parameters
   * @throws BadCallMethodException
   */
  public function __construct(...$parameters)
  {
    parent::__construct('WEEKDAY', $parameters);
  }
  
}