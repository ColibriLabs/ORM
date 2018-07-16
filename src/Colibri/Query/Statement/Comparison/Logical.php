<?php

namespace Colibri\Query\Statement\Comparison;

use Colibri\Exception\BadArgumentException;

/**
 * Class LogicalCondition
 * @package Colibri\Query\Comparison
 */
class Logical extends Comparison
{
    
    /**
     * @return string
     * @throws BadArgumentException
     */
    protected function buildCondition()
    {
        $left = $this->stringifyExpression($this->getLeftExpression());
        $right = $this->stringifyExpression($this->getRightExpression());
        
        return sprintf('%s %s %s', $left, $this->getComparator(), $right);
    }
    
}