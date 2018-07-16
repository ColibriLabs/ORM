<?php

namespace Colibri\Query\Expr\Func;

use Colibri\Exception\BadCallMethodException;
use Colibri\Query\Expr\Func;

class CharacterLength extends Func
{
    
    /**
     * CharacterLength constructor.
     * MySQL Function CHARACTER_LENGTH
     *
     * @param array $parameters
     *
     * @throws BadCallMethodException
     */
    public function __construct(...$parameters)
    {
        parent::__construct('CHARACTER_LENGTH', $parameters);
    }
    
}