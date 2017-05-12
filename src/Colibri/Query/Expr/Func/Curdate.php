<?php

namespace Colibri\Query\Expr\Func;

use Colibri\Query\Expr\Func;
use Colibri\Exception\BadCallMethodException;

class Curdate extends Func
{

  /**
   * Curdate constructor.
   * MySQL Function CURDATE
   *
   * @param array $parameters
   * @throws BadCallMethodException
   */
  public function __construct(...$parameters)
  {
    parent::__construct('CURDATE', $parameters);
  }
  
}