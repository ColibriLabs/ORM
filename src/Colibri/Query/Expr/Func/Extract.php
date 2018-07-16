<?php

namespace Colibri\Query\Expr\Func;

use Colibri\Exception\BadCallMethodException;
use Colibri\Query\Expr\Func;

class Extract extends Func
{
    
    /**
     * Extract constructor.
     * MySQL Function EXTRACT
     *
     * @param array $parameters
     *
     * @throws BadCallMethodException
     */
    public function __construct(...$parameters)
    {
        parent::__construct('EXTRACT', $parameters);
    }
    
}