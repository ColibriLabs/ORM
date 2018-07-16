<?php

namespace Colibri\Query\Expr\Func;

use Colibri\Exception\BadCallMethodException;
use Colibri\Query\Expr\Func;

class Log10 extends Func
{
    
    /**
     * Log10 constructor.
     * MySQL Function LOG10
     *
     * @param array $parameters
     *
     * @throws BadCallMethodException
     */
    public function __construct(...$parameters)
    {
        parent::__construct('LOG10', $parameters);
    }
    
}