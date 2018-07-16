<?php

namespace Colibri\Query\Expr\Func;

use Colibri\Exception\BadCallMethodException;
use Colibri\Query\Expr\Func;

class Ltrim extends Func
{
    
    /**
     * Ltrim constructor.
     * MySQL Function LTRIM
     *
     * @param array $parameters
     *
     * @throws BadCallMethodException
     */
    public function __construct(...$parameters)
    {
        parent::__construct('LTRIM', $parameters);
    }
    
}