<?php

namespace Colibri\Query\Expr\Func;

use Colibri\Exception\BadCallMethodException;
use Colibri\Query\Expr\Func;

class Upper extends Func
{
    
    /**
     * Upper constructor.
     * MySQL Function UPPER
     *
     * @param array $parameters
     *
     * @throws BadCallMethodException
     */
    public function __construct(...$parameters)
    {
        parent::__construct('UPPER', $parameters);
    }
    
}