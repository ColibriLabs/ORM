<?php

namespace Colibri\Query\Expr\Func;

use Colibri\Exception\BadCallMethodException;
use Colibri\Query\Expr\Func;

class Addtime extends Func
{
    
    /**
     * Addtime constructor.
     * MySQL Function ADDTIME
     *
     * @param array $parameters
     *
     * @throws BadCallMethodException
     */
    public function __construct(...$parameters)
    {
        parent::__construct('ADDTIME', $parameters);
    }
    
}