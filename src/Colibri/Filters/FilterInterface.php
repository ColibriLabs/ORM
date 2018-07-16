<?php

namespace Colibri\Filters;

/**
 * Interface FilterInterface
 * @package Colibri\Filters
 */
interface FilterInterface
{
    
    /**
     * @param string|integer|array $input
     *
     * @return string|integer|array
     */
    public function apply($input);
    
}