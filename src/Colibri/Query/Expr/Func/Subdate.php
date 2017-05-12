<?php

namespace Colibri\Query\Expr\Func;

use Colibri\Query\Expr\Func;
use Colibri\Exception\BadCallMethodException;

class Subdate extends Func
{

  /**
   * Subdate constructor.
   * MySQL Function SUBDATE
   *
   * @param array $parameters
   * @throws BadCallMethodException
   */
  public function __construct(...$parameters)
  {
    parent::__construct('SUBDATE', $parameters);
  }
  
}