<?php

namespace Colibri\Query\Expr\Func;

use Colibri\Query\Expr\Func;
use Colibri\Exception\BadCallMethodException;

class Database extends Func
{

  /**
   * Database constructor.
   * MySQL Function DATABASE
   *
   * @param array $parameters
   * @throws BadCallMethodException
   */
  public function __construct(...$parameters)
  {
    parent::__construct('DATABASE', $parameters);
  }
  
}