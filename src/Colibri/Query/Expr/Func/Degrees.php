<?php

namespace Colibri\Query\Expr\Func;

use Colibri\Exception\BadCallMethodException;
use Colibri\Query\Expr\Func;

class Degrees extends Func
{
    
    /**
     * Degrees constructor.
     * MySQL Function DEGREES
     *
     * @param array $parameters
     *
     * @throws BadCallMethodException
     */
    public function __construct(...$parameters)
    {
        parent::__construct('DEGREES', $parameters);
    }
    
}