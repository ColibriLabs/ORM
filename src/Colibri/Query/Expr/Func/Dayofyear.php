<?php

namespace Colibri\Query\Expr\Func;

use Colibri\Exception\BadCallMethodException;
use Colibri\Query\Expr\Func;

class Dayofyear extends Func
{
    
    /**
     * Dayofyear constructor.
     * MySQL Function DAYOFYEAR
     *
     * @param array $parameters
     *
     * @throws BadCallMethodException
     */
    public function __construct(...$parameters)
    {
        parent::__construct('DAYOFYEAR', $parameters);
    }
    
}