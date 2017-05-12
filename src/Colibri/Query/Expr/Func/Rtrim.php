<?php

namespace Colibri\Query\Expr\Func;

use Colibri\Query\Expr\Func;
use Colibri\Exception\BadCallMethodException;

class Rtrim extends Func
{

  /**
   * Rtrim constructor.
   * MySQL Function RTRIM
   *
   * @param array $parameters
   * @throws BadCallMethodException
   */
  public function __construct(...$parameters)
  {
    parent::__construct('RTRIM', $parameters);
  }
  
}