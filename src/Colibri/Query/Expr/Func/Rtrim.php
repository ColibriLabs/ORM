<?php

namespace Colibri\Query\Expr\Func;

use Colibri\Exception\BadCallMethodException;
use Colibri\Query\Expr\Func;

class Rtrim extends Func
{
    
    /**
     * Rtrim constructor.
     * MySQL Function RTRIM
     *
     * @param array $parameters
     *
     * @throws BadCallMethodException
     */
    public function __construct(...$parameters)
    {
        parent::__construct('RTRIM', $parameters);
    }
    
}