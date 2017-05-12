<?php

namespace Colibri\Query\Expr\Func;

use Colibri\Query\Expr\Func;
use Colibri\Exception\BadCallMethodException;

class CharLength extends Func
{

  /**
   * CharLength constructor.
   * MySQL Function CHAR_LENGTH
   *
   * @param array $parameters
   * @throws BadCallMethodException
   */
  public function __construct(...$parameters)
  {
    parent::__construct('CHAR_LENGTH', $parameters);
  }
  
}