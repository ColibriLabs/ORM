<?php

namespace Colibri\Query\Expr\Func;

use Colibri\Exception\BadCallMethodException;
use Colibri\Query\Expr\Func;

class CurrentUser extends Func
{
    
    /**
     * CurrentUser constructor.
     * MySQL Function CURRENT_USER
     *
     * @param array $parameters
     *
     * @throws BadCallMethodException
     */
    public function __construct(...$parameters)
    {
        parent::__construct('CURRENT_USER', $parameters);
    }
    
}