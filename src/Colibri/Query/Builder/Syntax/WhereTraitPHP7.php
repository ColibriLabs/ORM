<?php

namespace Colibri\Query\Builder\Syntax;

use Colibri\Query\Statement\Comparison\Cmp;

/**
 * Class WhereTraitPHP7
 * @package Colibri\Query\Builder\Syntax
 */
trait WhereTraitPHP7
{
    
    use WhereTrait;
    
    /**
     * @param        $left
     * @param        $right
     * @param string $comparator
     *
     * @return $this
     */
    public function and ($left, $right, $comparator = Cmp::EQ)
    {
        $this->getWhereStatement()->where($left, $right, $comparator, Cmp::ET);
        
        return $this;
    }
    
    /**
     * @param        $left
     * @param        $right
     * @param string $comparator
     *
     * @return $this
     */
    public function or ($left, $right, $comparator = Cmp::EQ)
    {
        $this->getWhereStatement()->where($left, $right, $comparator, Cmp::VEL);
        
        return $this;
    }
    
}