<?php

namespace Colibri\Query\Expr\Func;

use Colibri\Query\Expr\Func;
use Colibri\Exception\BadCallMethodException;

class Subtime extends Func
{

  /**
   * Subtime constructor.
   * MySQL Function SUBTIME
   *
   * @param array $parameters
   * @throws BadCallMethodException
   */
  public function __construct(...$parameters)
  {
    parent::__construct('SUBTIME', $parameters);
  }
  
}