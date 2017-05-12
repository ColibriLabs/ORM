<?php

namespace Colibri\Query\Expr\Func;

use Colibri\Query\Expr\Func;
use Colibri\Exception\BadCallMethodException;

class FromDays extends Func
{

  /**
   * FromDays constructor.
   * MySQL Function FROM_DAYS
   *
   * @param array $parameters
   * @throws BadCallMethodException
   */
  public function __construct(...$parameters)
  {
    parent::__construct('FROM_DAYS', $parameters);
  }
  
}