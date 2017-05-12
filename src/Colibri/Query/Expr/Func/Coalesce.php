<?php

namespace Colibri\Query\Expr\Func;

use Colibri\Query\Expr\Func;
use Colibri\Exception\BadCallMethodException;

class Coalesce extends Func
{

  /**
   * Coalesce constructor.
   * MySQL Function COALESCE
   *
   * @param array $parameters
   * @throws BadCallMethodException
   */
  public function __construct(...$parameters)
  {
    parent::__construct('COALESCE', $parameters);
  }
  
}