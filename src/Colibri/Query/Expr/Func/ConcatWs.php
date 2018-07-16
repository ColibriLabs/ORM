<?php

namespace Colibri\Query\Expr\Func;

use Colibri\Exception\BadCallMethodException;
use Colibri\Query\Expr\Func;

class ConcatWs extends Func
{
    
    /**
     * ConcatWs constructor.
     * MySQL Function CONCAT_WS
     *
     * @param array $parameters
     *
     * @throws BadCallMethodException
     */
    public function __construct(...$parameters)
    {
        parent::__construct('CONCAT_WS', $parameters);
    }
    
}