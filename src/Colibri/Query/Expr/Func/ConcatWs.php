<?php

namespace Colibri\Query\Expr\Func;

use Colibri\Query\Expr\Func;
use Colibri\Exception\BadCallMethodException;

class ConcatWs extends Func
{

  /**
   * ConcatWs constructor.
   * MySQL Function CONCAT_WS
   *
   * @param array $parameters
   * @throws BadCallMethodException
   */
  public function __construct(...$parameters)
  {
    parent::__construct('CONCAT_WS', $parameters);
  }
  
}