<?php

namespace Colibri\Query\Expr\Func;

use Colibri\Query\Expr\Func;
use Colibri\Exception\BadCallMethodException;

class Timestamp extends Func
{

  /**
   * Timestamp constructor.
   * MySQL Function TIMESTAMP
   *
   * @param array $parameters
   * @throws BadCallMethodException
   */
  public function __construct(...$parameters)
  {
    parent::__construct('TIMESTAMP', $parameters);
  }
  
}