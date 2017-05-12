<?php

namespace Colibri\Query\Expr\Func;

use Colibri\Query\Expr\Func;
use Colibri\Exception\BadCallMethodException;

class Yearweek extends Func
{

  /**
   * Yearweek constructor.
   * MySQL Function YEARWEEK
   *
   * @param array $parameters
   * @throws BadCallMethodException
   */
  public function __construct(...$parameters)
  {
    parent::__construct('YEARWEEK', $parameters);
  }
  
}