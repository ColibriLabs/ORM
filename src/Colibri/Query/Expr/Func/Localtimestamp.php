<?php

namespace Colibri\Query\Expr\Func;

use Colibri\Exception\BadCallMethodException;
use Colibri\Query\Expr\Func;

class Localtimestamp extends Func
{
    
    /**
     * Localtimestamp constructor.
     * MySQL Function LOCALTIMESTAMP
     *
     * @param array $parameters
     *
     * @throws BadCallMethodException
     */
    public function __construct(...$parameters)
    {
        parent::__construct('LOCALTIMESTAMP', $parameters);
    }
    
}