<?php

namespace Colibri\Query\Expr\Func;

use Colibri\Exception\BadCallMethodException;
use Colibri\Query\Expr\Func;

class Encrypt extends Func
{
    
    /**
     * Encrypt constructor.
     * MySQL Function ENCRYPT
     *
     * @param array $parameters
     *
     * @throws BadCallMethodException
     */
    public function __construct(...$parameters)
    {
        parent::__construct('ENCRYPT', $parameters);
    }
    
}