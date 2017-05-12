<?php

namespace Colibri\Query\Expr\Func;

use Colibri\Query\Expr\Func;
use Colibri\Exception\BadCallMethodException;

class Ucase extends Func
{

  /**
   * Ucase constructor.
   * MySQL Function UCASE
   *
   * @param array $parameters
   * @throws BadCallMethodException
   */
  public function __construct(...$parameters)
  {
    parent::__construct('UCASE', $parameters);
  }
  
}