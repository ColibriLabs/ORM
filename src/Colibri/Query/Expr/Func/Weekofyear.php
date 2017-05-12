<?php

namespace Colibri\Query\Expr\Func;

use Colibri\Query\Expr\Func;
use Colibri\Exception\BadCallMethodException;

class Weekofyear extends Func
{

  /**
   * Weekofyear constructor.
   * MySQL Function WEEKOFYEAR
   *
   * @param array $parameters
   * @throws BadCallMethodException
   */
  public function __construct(...$parameters)
  {
    parent::__construct('WEEKOFYEAR', $parameters);
  }
  
}