<?php

namespace Colibri\Query\Expr\Func;

use Colibri\Query\Expr\Func;
use Colibri\Exception\BadCallMethodException;

class Rpad extends Func
{

  /**
   * Rpad constructor.
   * MySQL Function RPAD
   *
   * @param array $parameters
   * @throws BadCallMethodException
   */
  public function __construct(...$parameters)
  {
    parent::__construct('RPAD', $parameters);
  }
  
}