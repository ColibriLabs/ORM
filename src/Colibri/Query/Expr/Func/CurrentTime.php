<?php

namespace Colibri\Query\Expr\Func;

use Colibri\Exception\BadCallMethodException;
use Colibri\Query\Expr\Func;

class CurrentTime extends Func
{
    
    /**
     * CurrentTime constructor.
     * MySQL Function CURRENT_TIME
     *
     * @param array $parameters
     *
     * @throws BadCallMethodException
     */
    public function __construct(...$parameters)
    {
        parent::__construct('CURRENT_TIME', $parameters);
    }
    
}