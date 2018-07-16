<?php

namespace Colibri\Query\Expr\Func;

use Colibri\Exception\BadCallMethodException;
use Colibri\Query\Expr\Func;

class Radians extends Func
{
    
    /**
     * Radians constructor.
     * MySQL Function RADIANS
     *
     * @param array $parameters
     *
     * @throws BadCallMethodException
     */
    public function __construct(...$parameters)
    {
        parent::__construct('RADIANS', $parameters);
    }
    
}