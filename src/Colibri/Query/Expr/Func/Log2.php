<?php

namespace Colibri\Query\Expr\Func;

use Colibri\Query\Expr\Func;
use Colibri\Exception\BadCallMethodException;

class Log2 extends Func
{

  /**
   * Log2 constructor.
   * MySQL Function LOG2
   *
   * @param array $parameters
   * @throws BadCallMethodException
   */
  public function __construct(...$parameters)
  {
    parent::__construct('LOG2', $parameters);
  }
  
}