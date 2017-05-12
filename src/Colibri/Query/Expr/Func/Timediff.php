<?php

namespace Colibri\Query\Expr\Func;

use Colibri\Query\Expr\Func;
use Colibri\Exception\BadCallMethodException;

class Timediff extends Func
{

  /**
   * Timediff constructor.
   * MySQL Function TIMEDIFF
   *
   * @param array $parameters
   * @throws BadCallMethodException
   */
  public function __construct(...$parameters)
  {
    parent::__construct('TIMEDIFF', $parameters);
  }
  
}