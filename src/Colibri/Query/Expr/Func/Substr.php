<?php

namespace Colibri\Query\Expr\Func;

use Colibri\Query\Expr\Func;
use Colibri\Exception\BadCallMethodException;

class Substr extends Func
{

  /**
   * Substr constructor.
   * MySQL Function SUBSTR
   *
   * @param array $parameters
   * @throws BadCallMethodException
   */
  public function __construct(...$parameters)
  {
    parent::__construct('SUBSTR', $parameters);
  }
  
}