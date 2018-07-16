<?php

namespace Colibri\Filters;

/**
 * Class IntegerFilter
 * @package Colibri\Filters
 */
class IntegerFilter extends AbstractFilter
{
    
    /**
     * @inheritdoc
     */
    public function apply($input)
    {
        return (integer) $input;
    }
    
}