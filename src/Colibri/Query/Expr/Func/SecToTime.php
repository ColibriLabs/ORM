<?php

namespace Colibri\Query\Expr\Func;

use Colibri\Exception\BadCallMethodException;
use Colibri\Query\Expr\Func;

class SecToTime extends Func
{
    
    /**
     * SecToTime constructor.
     * MySQL Function SEC_TO_TIME
     *
     * @param array $parameters
     *
     * @throws BadCallMethodException
     */
    public function __construct(...$parameters)
    {
        parent::__construct('SEC_TO_TIME', $parameters);
    }
    
}