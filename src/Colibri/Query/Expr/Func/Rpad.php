<?php

namespace Colibri\Query\Expr\Func;

use Colibri\Exception\BadCallMethodException;
use Colibri\Query\Expr\Func;

class Rpad extends Func
{
    
    /**
     * Rpad constructor.
     * MySQL Function RPAD
     *
     * @param array $parameters
     *
     * @throws BadCallMethodException
     */
    public function __construct(...$parameters)
    {
        parent::__construct('RPAD', $parameters);
    }
    
}