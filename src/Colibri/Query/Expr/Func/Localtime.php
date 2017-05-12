<?php

namespace Colibri\Query\Expr\Func;

use Colibri\Query\Expr\Func;
use Colibri\Exception\BadCallMethodException;

class Localtime extends Func
{

  /**
   * Localtime constructor.
   * MySQL Function LOCALTIME
   *
   * @param array $parameters
   * @throws BadCallMethodException
   */
  public function __construct(...$parameters)
  {
    parent::__construct('LOCALTIME', $parameters);
  }
  
}