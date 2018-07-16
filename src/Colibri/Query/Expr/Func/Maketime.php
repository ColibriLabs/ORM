<?php

namespace Colibri\Query\Expr\Func;

use Colibri\Exception\BadCallMethodException;
use Colibri\Query\Expr\Func;

class Maketime extends Func
{
    
    /**
     * Maketime constructor.
     * MySQL Function MAKETIME
     *
     * @param array $parameters
     *
     * @throws BadCallMethodException
     */
    public function __construct(...$parameters)
    {
        parent::__construct('MAKETIME', $parameters);
    }
    
}