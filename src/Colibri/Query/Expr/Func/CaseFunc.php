<?php

namespace Colibri\Query\Expr\Func;

use Colibri\Exception\BadCallMethodException;
use Colibri\Query\Expr\Func;

class CaseFunc extends Func
{
    
    /**
     * CaseFunc constructor.
     * MySQL Function CASE
     *
     * @param array $parameters
     *
     * @throws BadCallMethodException
     */
    public function __construct(...$parameters)
    {
        parent::__construct('CASE', $parameters);
    }
    
}