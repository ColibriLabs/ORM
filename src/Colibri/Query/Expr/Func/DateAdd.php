<?php

namespace Colibri\Query\Expr\Func;

use Colibri\Exception\BadCallMethodException;
use Colibri\Query\Expr\Func;

class DateAdd extends Func
{
    
    /**
     * DateAdd constructor.
     * MySQL Function DATE_ADD
     *
     * @param array $parameters
     *
     * @throws BadCallMethodException
     */
    public function __construct(...$parameters)
    {
        parent::__construct('DATE_ADD', $parameters);
    }
    
}