<?php

namespace Colibri\Query\Expr\Func;

use Colibri\Query\Expr\Func;
use Colibri\Exception\BadCallMethodException;

class LastInsertId extends Func
{

  /**
   * LastInsertId constructor.
   * MySQL Function LAST_INSERT_ID
   *
   * @param array $parameters
   * @throws BadCallMethodException
   */
  public function __construct(...$parameters)
  {
    parent::__construct('LAST_INSERT_ID', $parameters);
  }
  
}