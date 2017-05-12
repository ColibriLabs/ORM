<?php

namespace Colibri\Query\Expr\Func;

use Colibri\Query\Expr\Func;
use Colibri\Exception\BadCallMethodException;

class Adddate extends Func
{

  /**
   * Adddate constructor.
   * MySQL Function ADDDATE
   *
   * @param array $parameters
   * @throws BadCallMethodException
   */
  public function __construct(...$parameters)
  {
    parent::__construct('ADDDATE', $parameters);
  }
  
}