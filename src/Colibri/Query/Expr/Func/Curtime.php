<?php

namespace Colibri\Query\Expr\Func;

use Colibri\Exception\BadCallMethodException;
use Colibri\Query\Expr\Func;

class Curtime extends Func
{
    
    /**
     * Curtime constructor.
     * MySQL Function CURTIME
     *
     * @param array $parameters
     *
     * @throws BadCallMethodException
     */
    public function __construct(...$parameters)
    {
        parent::__construct('CURTIME', $parameters);
    }
    
}