<?php

namespace Colibri\Query\Expr\Func;

use Colibri\Exception\BadCallMethodException;
use Colibri\Query\Expr\Func;

class Quarter extends Func
{
    
    /**
     * Quarter constructor.
     * MySQL Function QUARTER
     *
     * @param array $parameters
     *
     * @throws BadCallMethodException
     */
    public function __construct(...$parameters)
    {
        parent::__construct('QUARTER', $parameters);
    }
    
}