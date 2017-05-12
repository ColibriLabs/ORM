<?php

namespace Colibri\Query\Expr\Func;

use Colibri\Query\Expr\Func;
use Colibri\Exception\BadCallMethodException;

class Atan extends Func
{

  /**
   * Atan constructor.
   * MySQL Function ATAN
   *
   * @param array $parameters
   * @throws BadCallMethodException
   */
  public function __construct(...$parameters)
  {
    parent::__construct('ATAN', $parameters);
  }
  
}