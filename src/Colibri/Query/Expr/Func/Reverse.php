<?php

namespace Colibri\Query\Expr\Func;

use Colibri\Exception\BadCallMethodException;
use Colibri\Query\Expr\Func;

class Reverse extends Func
{
    
    /**
     * Reverse constructor.
     * MySQL Function REVERSE
     *
     * @param array $parameters
     *
     * @throws BadCallMethodException
     */
    public function __construct(...$parameters)
    {
        parent::__construct('REVERSE', $parameters);
    }
    
}