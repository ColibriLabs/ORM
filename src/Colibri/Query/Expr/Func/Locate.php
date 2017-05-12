<?php

namespace Colibri\Query\Expr\Func;

use Colibri\Query\Expr\Func;
use Colibri\Exception\BadCallMethodException;

class Locate extends Func
{

  /**
   * Locate constructor.
   * MySQL Function LOCATE
   *
   * @param array $parameters
   * @throws BadCallMethodException
   */
  public function __construct(...$parameters)
  {
    parent::__construct('LOCATE', $parameters);
  }
  
}