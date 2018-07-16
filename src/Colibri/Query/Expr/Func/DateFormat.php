<?php

namespace Colibri\Query\Expr\Func;

use Colibri\Exception\BadCallMethodException;
use Colibri\Query\Expr\Func;

class DateFormat extends Func
{
    
    /**
     * DateFormat constructor.
     * MySQL Function DATE_FORMAT
     *
     * @param array $parameters
     *
     * @throws BadCallMethodException
     */
    public function __construct(...$parameters)
    {
        parent::__construct('DATE_FORMAT', $parameters);
    }
    
}