<?php

namespace Colibri\Query\Expr\Func;

use Colibri\Query\Expr\Func;
use Colibri\Exception\BadCallMethodException;

class Insert extends Func
{

  /**
   * Insert constructor.
   * MySQL Function INSERT
   *
   * @param array $parameters
   * @throws BadCallMethodException
   */
  public function __construct(...$parameters)
  {
    parent::__construct('INSERT', $parameters);
  }
  
}