<?php

namespace Colibri\Query\Expr\Func;

use Colibri\Query\Expr\Func;
use Colibri\Exception\BadCallMethodException;

class Lcase extends Func
{

  /**
   * Lcase constructor.
   * MySQL Function LCASE
   *
   * @param array $parameters
   * @throws BadCallMethodException
   */
  public function __construct(...$parameters)
  {
    parent::__construct('LCASE', $parameters);
  }
  
}