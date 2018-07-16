<?php

namespace Colibri\Query\Expr\Func;

use Colibri\Exception\BadCallMethodException;
use Colibri\Query\Expr\Func;

class LastInsertId extends Func
{
    
    /**
     * LastInsertId constructor.
     * MySQL Function LAST_INSERT_ID
     *
     * @param array $parameters
     *
     * @throws BadCallMethodException
     */
    public function __construct(...$parameters)
    {
        parent::__construct('LAST_INSERT_ID', $parameters);
    }
    
}