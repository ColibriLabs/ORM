<?php

namespace Colibri\Query\Expr\Func;

use Colibri\Exception\BadCallMethodException;
use Colibri\Query\Expr\Func;

class Insert extends Func
{
    
    /**
     * Insert constructor.
     * MySQL Function INSERT
     *
     * @param array $parameters
     *
     * @throws BadCallMethodException
     */
    public function __construct(...$parameters)
    {
        parent::__construct('INSERT', $parameters);
    }
    
}