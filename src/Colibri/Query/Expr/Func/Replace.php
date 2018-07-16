<?php

namespace Colibri\Query\Expr\Func;

use Colibri\Exception\BadCallMethodException;
use Colibri\Query\Expr\Func;

class Replace extends Func
{
    
    /**
     * Replace constructor.
     * MySQL Function REPLACE
     *
     * @param array $parameters
     *
     * @throws BadCallMethodException
     */
    public function __construct(...$parameters)
    {
        parent::__construct('REPLACE', $parameters);
    }
    
}