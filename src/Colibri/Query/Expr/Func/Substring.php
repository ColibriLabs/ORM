<?php

namespace Colibri\Query\Expr\Func;

use Colibri\Query\Expr\Func;
use Colibri\Exception\BadCallMethodException;

class Substring extends Func
{

  /**
   * Substring constructor.
   * MySQL Function SUBSTRING
   *
   * @param array $parameters
   * @throws BadCallMethodException
   */
  public function __construct(...$parameters)
  {
    parent::__construct('SUBSTRING', $parameters);
  }
  
}