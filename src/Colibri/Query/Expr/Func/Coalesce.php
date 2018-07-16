<?php

namespace Colibri\Query\Expr\Func;

use Colibri\Exception\BadCallMethodException;
use Colibri\Query\Expr\Func;

class Coalesce extends Func
{
    
    /**
     * Coalesce constructor.
     * MySQL Function COALESCE
     *
     * @param array $parameters
     *
     * @throws BadCallMethodException
     */
    public function __construct(...$parameters)
    {
        parent::__construct('COALESCE', $parameters);
    }
    
}