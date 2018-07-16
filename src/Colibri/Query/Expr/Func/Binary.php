<?php

namespace Colibri\Query\Expr\Func;

use Colibri\Exception\BadCallMethodException;
use Colibri\Query\Expr\Func;

class Binary extends Func
{
    
    /**
     * Binary constructor.
     * MySQL Function BINARY
     *
     * @param array $parameters
     *
     * @throws BadCallMethodException
     */
    public function __construct(...$parameters)
    {
        parent::__construct('BINARY', $parameters);
    }
    
}