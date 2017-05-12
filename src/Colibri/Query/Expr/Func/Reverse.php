<?php

namespace Colibri\Query\Expr\Func;

use Colibri\Query\Expr\Func;
use Colibri\Exception\BadCallMethodException;

class Reverse extends Func
{

  /**
   * Reverse constructor.
   * MySQL Function REVERSE
   *
   * @param array $parameters
   * @throws BadCallMethodException
   */
  public function __construct(...$parameters)
  {
    parent::__construct('REVERSE', $parameters);
  }
  
}