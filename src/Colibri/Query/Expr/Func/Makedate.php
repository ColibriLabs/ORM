<?php

namespace Colibri\Query\Expr\Func;

use Colibri\Exception\BadCallMethodException;
use Colibri\Query\Expr\Func;

class Makedate extends Func
{
    
    /**
     * Makedate constructor.
     * MySQL Function MAKEDATE
     *
     * @param array $parameters
     *
     * @throws BadCallMethodException
     */
    public function __construct(...$parameters)
    {
        parent::__construct('MAKEDATE', $parameters);
    }
    
}