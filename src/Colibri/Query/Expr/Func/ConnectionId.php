<?php

namespace Colibri\Query\Expr\Func;

use Colibri\Query\Expr\Func;
use Colibri\Exception\BadCallMethodException;

class ConnectionId extends Func
{

  /**
   * ConnectionId constructor.
   * MySQL Function CONNECTION_ID
   *
   * @param array $parameters
   * @throws BadCallMethodException
   */
  public function __construct(...$parameters)
  {
    parent::__construct('CONNECTION_ID', $parameters);
  }
  
}