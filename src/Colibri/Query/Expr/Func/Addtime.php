<?php

namespace Colibri\Query\Expr\Func;

use Colibri\Query\Expr\Func;
use Colibri\Exception\BadCallMethodException;

class Addtime extends Func
{

  /**
   * Addtime constructor.
   * MySQL Function ADDTIME
   *
   * @param array $parameters
   * @throws BadCallMethodException
   */
  public function __construct(...$parameters)
  {
    parent::__construct('ADDTIME', $parameters);
  }
  
}