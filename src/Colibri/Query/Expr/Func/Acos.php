<?php

namespace Colibri\Query\Expr\Func;

use Colibri\Query\Expr\Func;
use Colibri\Exception\BadCallMethodException;

class Acos extends Func
{

  /**
   * Acos constructor.
   * MySQL Function ACOS
   *
   * @param array $parameters
   * @throws BadCallMethodException
   */
  public function __construct(...$parameters)
  {
    parent::__construct('ACOS', $parameters);
  }
  
}