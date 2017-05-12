<?php

namespace Colibri\Query\Expr\Func;

use Colibri\Query\Expr\Func;
use Colibri\Exception\BadCallMethodException;

class CurrentTimestamp extends Func
{

  /**
   * CurrentTimestamp constructor.
   * MySQL Function CURRENT_TIMESTAMP
   *
   * @param array $parameters
   * @throws BadCallMethodException
   */
  public function __construct(...$parameters)
  {
    parent::__construct('CURRENT_TIMESTAMP', $parameters);
  }
  
}