<?php

namespace Colibri\Query\Expr\Func;

use Colibri\Query\Expr\Func;

/**
 * Class GroupConcat
 * @package Colibri\Query\Expr\Func
 */
class GroupConcat extends Func
{
  
  /**
   * GroupConcat constructor.
   * @param array ...$parameters
   */
  public function __construct(...$parameters)
  {
    parent::__construct('GROUP_CONCAT', $parameters);
  }
  
}
