<?php

namespace Colibri\Query\Expr\Func;

use Colibri\Query\Expr\Func;
use Colibri\Exception\BadCallMethodException;

class Truncate extends Func
{

  /**
   * Truncate constructor.
   * MySQL Function TRUNCATE
   *
   * @param array $parameters
   * @throws BadCallMethodException
   */
  public function __construct(...$parameters)
  {
    parent::__construct('TRUNCATE', $parameters);
  }
  
}