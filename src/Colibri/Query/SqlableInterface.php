<?php

namespace Colibri\Query;

/**
 * Interface SqlableInterface
 * @package Colibri\Query
 */
interface SqlableInterface
{
    
    /**
     * @return string
     */
    public function toSQL();
    
}