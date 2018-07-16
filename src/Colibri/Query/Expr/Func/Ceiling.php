<?php

namespace Colibri\Query\Expr\Func;

use Colibri\Exception\BadCallMethodException;
use Colibri\Query\Expr\Func;

class Ceiling extends Func
{
    
    /**
     * Ceiling constructor.
     * MySQL Function CEILING
     *
     * @param array $parameters
     *
     * @throws BadCallMethodException
     */
    public function __construct(...$parameters)
    {
        parent::__construct('CEILING', $parameters);
    }
    
}