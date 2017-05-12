<?php

namespace Colibri\Query\Expr\Func;

use Colibri\Query\Expr\Func;
use Colibri\Exception\BadCallMethodException;

class Repeat extends Func
{

  /**
   * Repeat constructor.
   * MySQL Function REPEAT
   *
   * @param array $parameters
   * @throws BadCallMethodException
   */
  public function __construct(...$parameters)
  {
    parent::__construct('REPEAT', $parameters);
  }
  
}