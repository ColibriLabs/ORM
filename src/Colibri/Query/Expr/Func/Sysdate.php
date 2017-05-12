<?php

namespace Colibri\Query\Expr\Func;

use Colibri\Query\Expr\Func;
use Colibri\Exception\BadCallMethodException;

class Sysdate extends Func
{

  /**
   * Sysdate constructor.
   * MySQL Function SYSDATE
   *
   * @param array $parameters
   * @throws BadCallMethodException
   */
  public function __construct(...$parameters)
  {
    parent::__construct('SYSDATE', $parameters);
  }
  
}