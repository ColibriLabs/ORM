<?php

namespace Colibri\Query\Builder\Syntax;

use Colibri\Query\Statement;

/**
 * Class SetTrait
 * @package Colibri\Query\Builder\Syntax
 */
trait SetTrait
{
    
    /**
     * @param $column
     * @param $value
     *
     * @return $this
     */
    public function setData($column, $value)
    {
        $this->getSetStatement()->set($column, $value);
        
        return $this;
    }
    
    /**
     * @param array $data
     *
     * @return $this
     */
    public function setDataBatch(array $data = [])
    {
        $this->getSetStatement()->batch($data);
        
        return $this;
    }
    
    /**
     * @return Statement\Set
     */
    abstract public function getSetStatement();
    
}