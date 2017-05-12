<?php

namespace Colibri\Query\Expr\Func;

use Colibri\Query\Expr\Func;
use Colibri\Exception\BadCallMethodException;

class Ceil extends Func
{

  /**
   * Ceil constructor.
   * MySQL Function CEIL
   *
   * @param array $parameters
   * @throws BadCallMethodException
   */
  public function __construct(...$parameters)
  {
    parent::__construct('CEIL', $parameters);
  }
  
}