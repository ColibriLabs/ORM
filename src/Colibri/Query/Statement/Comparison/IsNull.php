<?php

namespace Colibri\Query\Statement\Comparison;

/**
 * Class IsNull
 * @package Colibri\Query\Statement\Comparison
 */
class IsNull extends Comparison
{
    
    /**
     * @return string
     */
    protected function buildCondition()
    {
        return sprintf('%s %s NULL', $this->stringifyExpression($this->getLeftExpression()), $this->getComparator());
    }
    
}