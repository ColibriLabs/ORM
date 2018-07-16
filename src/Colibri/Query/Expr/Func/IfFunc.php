<?php

namespace Colibri\Query\Expr\Func;

use Colibri\Exception\BadCallMethodException;
use Colibri\Query\Expr\Func;

class IfFunc extends Func
{
    
    /**
     * IfFunc constructor.
     * MySQL Function IF
     *
     * @param array $parameters
     *
     * @throws BadCallMethodException
     */
    public function __construct(...$parameters)
    {
        parent::__construct('IF', $parameters);
    }
    
}