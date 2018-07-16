<?php

namespace Colibri\Query\Expr\Func;

use Colibri\Exception\BadCallMethodException;
use Colibri\Query\Expr\Func;

class Ifnull extends Func
{
    
    /**
     * Ifnull constructor.
     * MySQL Function IFNULL
     *
     * @param array $parameters
     *
     * @throws BadCallMethodException
     */
    public function __construct(...$parameters)
    {
        parent::__construct('IFNULL', $parameters);
    }
    
}