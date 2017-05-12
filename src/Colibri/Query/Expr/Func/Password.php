<?php

namespace Colibri\Query\Expr\Func;

use Colibri\Query\Expr\Func;
use Colibri\Exception\BadCallMethodException;

class Password extends Func
{

  /**
   * Password constructor.
   * MySQL Function PASSWORD
   *
   * @param array $parameters
   * @throws BadCallMethodException
   */
  public function __construct(...$parameters)
  {
    parent::__construct('PASSWORD', $parameters);
  }
  
}