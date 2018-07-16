<?php

namespace Colibri\Query\Expr\Func;

use Colibri\Exception\BadCallMethodException;
use Colibri\Query\Expr\Func;

class Sqrt extends Func
{
    
    /**
     * Sqrt constructor.
     * MySQL Function SQRT
     *
     * @param array $parameters
     *
     * @throws BadCallMethodException
     */
    public function __construct(...$parameters)
    {
        parent::__construct('SQRT', $parameters);
    }
    
}