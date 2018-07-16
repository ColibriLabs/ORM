<?php

namespace Colibri\Query\Expr\Func;

use Colibri\Exception\BadCallMethodException;
use Colibri\Query\Expr\Func;

class Atan2 extends Func
{
    
    /**
     * Atan2 constructor.
     * MySQL Function ATAN2
     *
     * @param array $parameters
     *
     * @throws BadCallMethodException
     */
    public function __construct(...$parameters)
    {
        parent::__construct('ATAN2', $parameters);
    }
    
}