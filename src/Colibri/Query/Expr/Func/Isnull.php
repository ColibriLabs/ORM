<?php

namespace Colibri\Query\Expr\Func;

use Colibri\Query\Expr\Func;
use Colibri\Exception\BadCallMethodException;

class Isnull extends Func
{

  /**
   * Isnull constructor.
   * MySQL Function ISNULL
   *
   * @param array $parameters
   * @throws BadCallMethodException
   */
  public function __construct(...$parameters)
  {
    parent::__construct('ISNULL', $parameters);
  }
  
}