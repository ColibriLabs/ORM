<?php

namespace Colibri\Filters;

/**
 * Class StringFilter
 * @package Colibri\Filters
 */
class StringFilter extends AbstractFilter
{
    
    /**
     * @inheritdoc
     */
    public function apply($input)
    {
        return (string) $input;
    }
    
}