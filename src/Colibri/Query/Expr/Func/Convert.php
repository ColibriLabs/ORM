<?php

namespace Colibri\Query\Expr\Func;

use Colibri\Exception\BadCallMethodException;
use Colibri\Query\Expr\Func;

class Convert extends Func
{
    
    /**
     * Convert constructor.
     * MySQL Function CONVERT
     *
     * @param array $parameters
     *
     * @throws BadCallMethodException
     */
    public function __construct(...$parameters)
    {
        parent::__construct('CONVERT', $parameters);
    }
    
}