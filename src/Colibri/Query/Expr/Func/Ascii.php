<?php

namespace Colibri\Query\Expr\Func;

use Colibri\Exception\BadCallMethodException;
use Colibri\Query\Expr\Func;

class Ascii extends Func
{
    
    /**
     * Ascii constructor.
     * MySQL Function ASCII
     *
     * @param array $parameters
     *
     * @throws BadCallMethodException
     */
    public function __construct(...$parameters)
    {
        parent::__construct('ASCII', $parameters);
    }
    
}