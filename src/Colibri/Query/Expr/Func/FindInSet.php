<?php

namespace Colibri\Query\Expr\Func;

use Colibri\Exception\BadCallMethodException;
use Colibri\Query\Expr\Func;

class FindInSet extends Func
{
    
    /**
     * FindInSet constructor.
     * MySQL Function FIND_IN_SET
     *
     * @param array $parameters
     *
     * @throws BadCallMethodException
     */
    public function __construct(...$parameters)
    {
        parent::__construct('FIND_IN_SET', $parameters);
    }
    
}