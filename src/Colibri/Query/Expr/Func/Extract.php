<?php

namespace Colibri\Query\Expr\Func;

use Colibri\Query\Expr\Func;
use Colibri\Exception\BadCallMethodException;

class Extract extends Func
{

  /**
   * Extract constructor.
   * MySQL Function EXTRACT
   *
   * @param array $parameters
   * @throws BadCallMethodException
   */
  public function __construct(...$parameters)
  {
    parent::__construct('EXTRACT', $parameters);
  }
  
}