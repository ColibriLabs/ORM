<?php

namespace Colibri\Query\Expr\Func;

use Colibri\Query\Expr\Func;
use Colibri\Exception\BadCallMethodException;

class IfFunc extends Func
{

  /**
   * IfFunc constructor.
   * MySQL Function IF
   *
   * @param array $parameters
   * @throws BadCallMethodException
   */
  public function __construct(...$parameters)
  {
    parent::__construct('IF', $parameters);
  }
  
}