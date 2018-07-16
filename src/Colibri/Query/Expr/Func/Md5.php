<?php

namespace Colibri\Query\Expr\Func;

use Colibri\Exception\BadCallMethodException;
use Colibri\Query\Expr\Func;

class Md5 extends Func
{
    
    /**
     * Md5 constructor.
     * MySQL Function MD5
     *
     * @param array $parameters
     *
     * @throws BadCallMethodException
     */
    public function __construct(...$parameters)
    {
        parent::__construct('MD5', $parameters);
    }
    
}