<?php

namespace Colibri\Query\Expr\Func;

use Colibri\Query\Expr\Func;
use Colibri\Exception\BadCallMethodException;

class Microsecond extends Func
{

  /**
   * Microsecond constructor.
   * MySQL Function MICROSECOND
   *
   * @param array $parameters
   * @throws BadCallMethodException
   */
  public function __construct(...$parameters)
  {
    parent::__construct('MICROSECOND', $parameters);
  }
  
}