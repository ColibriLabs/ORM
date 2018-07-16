<?php

namespace Colibri\Query\Expr\Func;

use Colibri\Exception\BadCallMethodException;
use Colibri\Query\Expr\Func;

class Monthname extends Func
{
    
    /**
     * Monthname constructor.
     * MySQL Function MONTHNAME
     *
     * @param array $parameters
     *
     * @throws BadCallMethodException
     */
    public function __construct(...$parameters)
    {
        parent::__construct('MONTHNAME', $parameters);
    }
    
}