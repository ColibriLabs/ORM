<?php

namespace Colibri\Query\Expr\Func;

use Colibri\Query\Expr\Func;
use Colibri\Exception\BadCallMethodException;

class Strcmp extends Func
{

  /**
   * Strcmp constructor.
   * MySQL Function STRCMP
   *
   * @param array $parameters
   * @throws BadCallMethodException
   */
  public function __construct(...$parameters)
  {
    parent::__construct('STRCMP', $parameters);
  }
  
}