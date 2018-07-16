<?php

namespace Colibri\Query\Expr\Func;

use Colibri\Exception\BadCallMethodException;
use Colibri\Query\Expr\Func;

class PeriodDiff extends Func
{
    
    /**
     * PeriodDiff constructor.
     * MySQL Function PERIOD_DIFF
     *
     * @param array $parameters
     *
     * @throws BadCallMethodException
     */
    public function __construct(...$parameters)
    {
        parent::__construct('PERIOD_DIFF', $parameters);
    }
    
}