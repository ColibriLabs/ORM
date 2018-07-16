<?php

namespace Colibri\Query\Expr\Func;

use Colibri\Exception\BadCallMethodException;
use Colibri\Query\Expr\Func;

class Adddate extends Func
{
    
    /**
     * Adddate constructor.
     * MySQL Function ADDDATE
     *
     * @param array $parameters
     *
     * @throws BadCallMethodException
     */
    public function __construct(...$parameters)
    {
        parent::__construct('ADDDATE', $parameters);
    }
    
}