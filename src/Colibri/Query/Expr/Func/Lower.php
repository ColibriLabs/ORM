<?php

namespace Colibri\Query\Expr\Func;

use Colibri\Query\Expr\Func;
use Colibri\Exception\BadCallMethodException;

class Lower extends Func
{

  /**
   * Lower constructor.
   * MySQL Function LOWER
   *
   * @param array $parameters
   * @throws BadCallMethodException
   */
  public function __construct(...$parameters)
  {
    parent::__construct('LOWER', $parameters);
  }
  
}