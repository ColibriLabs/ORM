<?php

namespace Colibri\Query\Expr\Func;

use Colibri\Query\Expr\Func;
use Colibri\Exception\BadCallMethodException;

class Concat extends Func
{

  /**
   * Concat constructor.
   * MySQL Function CONCAT
   *
   * @param array $parameters
   * @throws BadCallMethodException
   */
  public function __construct(...$parameters)
  {
    parent::__construct('CONCAT', $parameters);
  }
  
}