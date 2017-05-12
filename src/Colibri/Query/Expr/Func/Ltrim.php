<?php

namespace Colibri\Query\Expr\Func;

use Colibri\Query\Expr\Func;
use Colibri\Exception\BadCallMethodException;

class Ltrim extends Func
{

  /**
   * Ltrim constructor.
   * MySQL Function LTRIM
   *
   * @param array $parameters
   * @throws BadCallMethodException
   */
  public function __construct(...$parameters)
  {
    parent::__construct('LTRIM', $parameters);
  }
  
}