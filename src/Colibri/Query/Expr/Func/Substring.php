<?php

namespace Colibri\Query\Expr\Func;

use Colibri\Exception\BadCallMethodException;
use Colibri\Query\Expr\Func;

class Substring extends Func
{
    
    /**
     * Substring constructor.
     * MySQL Function SUBSTRING
     *
     * @param array $parameters
     *
     * @throws BadCallMethodException
     */
    public function __construct(...$parameters)
    {
        parent::__construct('SUBSTRING', $parameters);
    }
    
}