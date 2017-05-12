<?php

namespace Colibri\Query\Expr\Func;

use Colibri\Query\Expr\Func;
use Colibri\Exception\BadCallMethodException;

class Encrypt extends Func
{

  /**
   * Encrypt constructor.
   * MySQL Function ENCRYPT
   *
   * @param array $parameters
   * @throws BadCallMethodException
   */
  public function __construct(...$parameters)
  {
    parent::__construct('ENCRYPT', $parameters);
  }
  
}