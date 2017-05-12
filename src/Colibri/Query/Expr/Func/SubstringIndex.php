<?php

namespace Colibri\Query\Expr\Func;

use Colibri\Query\Expr\Func;
use Colibri\Exception\BadCallMethodException;

class SubstringIndex extends Func
{

  /**
   * SubstringIndex constructor.
   * MySQL Function SUBSTRING_INDEX
   *
   * @param array $parameters
   * @throws BadCallMethodException
   */
  public function __construct(...$parameters)
  {
    parent::__construct('SUBSTRING_INDEX', $parameters);
  }
  
}