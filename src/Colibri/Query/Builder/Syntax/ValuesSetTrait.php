<?php

namespace Colibri\Query\Builder\Syntax;

use Colibri\Query\Statement\ValuesSet;

/**
 * Class ValuesSetTrait
 * @package Colibri\Query\Builder\Syntax
 */
trait ValuesSetTrait
{
    
    /**
     * @param array $values
     *
     * @return $this
     */
    public function setDataBatch(array $values)
    {
        $this->getValuesSetStatement()->setInsertData($values);
        
        return $this;
    }
    
    /**
     * @param \array[] ...$valuesStack
     *
     * @return $this
     */
    public function setDataBatchBulk(array ...$valuesStack)
    {
        foreach ($valuesStack as $valuesSet) {
            $this->getValuesSetStatement()->setInsertData($valuesSet);
        }
        
        return $this;
    }
    
    /**
     * @alias
     *
     * @param array $values
     *
     * @return $this
     */
    public function setInsertData(array $values)
    {
        $this->getValuesSetStatement()->setInsertData($values);
        
        return $this;
    }
    
    /**
     * @return ValuesSet
     */
    abstract public function getValuesSetStatement();
    
}