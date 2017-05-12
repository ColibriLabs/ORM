<?php

namespace Colibri\Query\Expr\Func;

use Colibri\Query\Expr\Func;
use Colibri\Exception\BadCallMethodException;

class LastDay extends Func
{

  /**
   * LastDay constructor.
   * MySQL Function LAST_DAY
   *
   * @param array $parameters
   * @throws BadCallMethodException
   */
  public function __construct(...$parameters)
  {
    parent::__construct('LAST_DAY', $parameters);
  }
  
}