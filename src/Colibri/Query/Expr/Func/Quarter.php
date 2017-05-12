<?php

namespace Colibri\Query\Expr\Func;

use Colibri\Query\Expr\Func;
use Colibri\Exception\BadCallMethodException;

class Quarter extends Func
{

  /**
   * Quarter constructor.
   * MySQL Function QUARTER
   *
   * @param array $parameters
   * @throws BadCallMethodException
   */
  public function __construct(...$parameters)
  {
    parent::__construct('QUARTER', $parameters);
  }
  
}