<?php

namespace Colibri\Query\Expr\Func;

use Colibri\Query\Expr\Func;
use Colibri\Exception\BadCallMethodException;

class Ceiling extends Func
{

  /**
   * Ceiling constructor.
   * MySQL Function CEILING
   *
   * @param array $parameters
   * @throws BadCallMethodException
   */
  public function __construct(...$parameters)
  {
    parent::__construct('CEILING', $parameters);
  }
  
}