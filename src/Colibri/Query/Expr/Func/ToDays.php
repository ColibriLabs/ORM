<?php

namespace Colibri\Query\Expr\Func;

use Colibri\Exception\BadCallMethodException;
use Colibri\Query\Expr\Func;

class ToDays extends Func
{
    
    /**
     * ToDays constructor.
     * MySQL Function TO_DAYS
     *
     * @param array $parameters
     *
     * @throws BadCallMethodException
     */
    public function __construct(...$parameters)
    {
        parent::__construct('TO_DAYS', $parameters);
    }
    
}