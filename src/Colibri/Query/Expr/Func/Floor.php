<?php

namespace Colibri\Query\Expr\Func;

use Colibri\Exception\BadCallMethodException;
use Colibri\Query\Expr\Func;

class Floor extends Func
{
    
    /**
     * Floor constructor.
     * MySQL Function FLOOR
     *
     * @param array $parameters
     *
     * @throws BadCallMethodException
     */
    public function __construct(...$parameters)
    {
        parent::__construct('FLOOR', $parameters);
    }
    
}