<?php

namespace Colibri\Query\Expr;

use Colibri\Exception\BadArgumentException;
use Colibri\Exception\BadCallMethodException;
use Colibri\Query\Expression;

/**
 * Class Parameters
 * @package Colibri\Query\Expr
 */
class Parameters extends Expression
{
    
    /**
     * @var array
     */
    protected $parameters = [];
    
    /**
     * Parameters constructor.
     *
     * @param array $parameters
     */
    public function __construct(array $parameters = [])
    {
        $this->setParameters($parameters);
    }
    
    /**
     * @param $parameter
     *
     * @return $this
     */
    public function append($parameter)
    {
        array_push($this->parameters, $this->normalizeParameter($parameter));
        
        return $this;
    }
    
    /**
     * @param $parameter
     *
     * @return $this
     */
    public function prepend($parameter)
    {
        array_unshift($this->parameters, $this->normalizeParameter($parameter));
        
        return $this;
    }
    
    /**
     * @param string|int|Expression $parameter
     *
     * @return Parameter
     * @throws BadArgumentException
     */
    private function normalizeParameter($parameter)
    {
        if (is_scalar($parameter)) {
            if (is_bool($parameter)) {
                $parameter = new Parameter($parameter, Parameter::TYPE_BOOLEAN);
            } elseif (is_numeric($parameter) || is_float($parameter) || is_double($parameter)) {
                $parameter = new Parameter($parameter, Parameter::TYPE_NUMERIC);
            } else {
                $parameter = new Parameter($parameter, Parameter::TYPE_STR);
            }
        }
        
        if (!($parameter instanceof Expression)) {
            throw new BadArgumentException(sprintf('Bad parameter passed. Allowed either scalar values or object %s extended',
                Expression::class));
        }
        
        return $parameter;
    }
    
    /**
     * @return $this
     */
    public function clearParameters()
    {
        $this->parameters = [];
        
        return $this;
    }
    
    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->toSQL();
    }
    
    /**
     * @return string
     * @throws BadCallMethodException
     */
    public function toSQL()
    {
        return implode(', ', $this->getParameters());
    }
    
    /**
     * @return Expression[]
     */
    public function getParameters()
    {
        return $this->parameters;
    }
    
    /**
     * @param array $parameters
     *
     * @return $this
     * @throws BadArgumentException
     */
    public function setParameters($parameters)
    {
        $this->parameters = [];
        
        foreach ($parameters as $parameter) {
            $this->append($parameter);
        }
        
        return $this;
    }
    
}
