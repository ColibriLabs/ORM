<?php

namespace Colibri\Query\Expr\Func;

use Colibri\Exception\BadCallMethodException;
use Colibri\Query\Expr\Func;

class Yearweek extends Func
{
    
    /**
     * Yearweek constructor.
     * MySQL Function YEARWEEK
     *
     * @param array $parameters
     *
     * @throws BadCallMethodException
     */
    public function __construct(...$parameters)
    {
        parent::__construct('YEARWEEK', $parameters);
    }
    
}