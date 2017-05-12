<?php

namespace Colibri\Query\Expr\Func;

use Colibri\Query\Expr\Func;
use Colibri\Exception\BadCallMethodException;

class Greatest extends Func
{

  /**
   * Greatest constructor.
   * MySQL Function GREATEST
   *
   * @param array $parameters
   * @throws BadCallMethodException
   */
  public function __construct(...$parameters)
  {
    parent::__construct('GREATEST', $parameters);
  }
  
}