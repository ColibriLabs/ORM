<?php

namespace Colibri\Query\Expr\Func;

use Colibri\Exception\BadCallMethodException;
use Colibri\Query\Expr\Func;

class Version extends Func
{
    
    /**
     * Version constructor.
     * MySQL Function VERSION
     *
     * @param array $parameters
     *
     * @throws BadCallMethodException
     */
    public function __construct(...$parameters)
    {
        parent::__construct('VERSION', $parameters);
    }
    
}