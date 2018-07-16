<?php

namespace Colibri\Query\Expr\Func;

use Colibri\Exception\BadCallMethodException;
use Colibri\Query\Expr\Func;

class Nullif extends Func
{
    
    /**
     * Nullif constructor.
     * MySQL Function NULLIF
     *
     * @param array $parameters
     *
     * @throws BadCallMethodException
     */
    public function __construct(...$parameters)
    {
        parent::__construct('NULLIF', $parameters);
    }
    
}