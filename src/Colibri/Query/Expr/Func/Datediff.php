<?php

namespace Colibri\Query\Expr\Func;

use Colibri\Exception\BadCallMethodException;
use Colibri\Query\Expr\Func;

class Datediff extends Func
{
    
    /**
     * Datediff constructor.
     * MySQL Function DATEDIFF
     *
     * @param array $parameters
     *
     * @throws BadCallMethodException
     */
    public function __construct(...$parameters)
    {
        parent::__construct('DATEDIFF', $parameters);
    }
    
}