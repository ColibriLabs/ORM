<?php

namespace Colibri\Query\Expr\Func;

use Colibri\Exception\BadCallMethodException;
use Colibri\Query\Expr\Func;

class Lpad extends Func
{
    
    /**
     * Lpad constructor.
     * MySQL Function LPAD
     *
     * @param array $parameters
     *
     * @throws BadCallMethodException
     */
    public function __construct(...$parameters)
    {
        parent::__construct('LPAD', $parameters);
    }
    
}