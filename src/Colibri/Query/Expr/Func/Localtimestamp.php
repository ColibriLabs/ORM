<?php

namespace Colibri\Query\Expr\Func;

use Colibri\Query\Expr\Func;
use Colibri\Exception\BadCallMethodException;

class Localtimestamp extends Func
{

  /**
   * Localtimestamp constructor.
   * MySQL Function LOCALTIMESTAMP
   *
   * @param array $parameters
   * @throws BadCallMethodException
   */
  public function __construct(...$parameters)
  {
    parent::__construct('LOCALTIMESTAMP', $parameters);
  }
  
}