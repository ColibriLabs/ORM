<?php

namespace Colibri\Query\Expr;

use Colibri\Query\Expression;

/**
 * Class Value
 * @package Colibri\Query\Expr
 */
class Parameter extends Expression
{
    
    const TYPE_STR     = \PDO::PARAM_STR;
    const TYPE_NUMERIC = \PDO::PARAM_INT;
    const TYPE_BOOLEAN = \PDO::PARAM_BOOL;
    
    /**
     * @var null
     */
    protected $parameter = null;
    
    /**
     * @var int
     */
    protected $parameterType = \PDO::PARAM_STR;
    
    /**
     * Parameter constructor.
     *
     * @param     $parameter
     * @param int $parameterType
     */
    public function __construct($parameter, $parameterType = \PDO::PARAM_STR)
    {
        $this->parameter = $parameter;
        $this->parameterType = $parameterType;
    }
    
    /**
     * @return null
     */
    public function getParameter()
    {
        return $this->parameter;
    }
    
    /**
     * @param mixed $parameter
     *
     * @return $this
     */
    public function setParameter($parameter)
    {
        $this->parameter = $parameter;
        
        return $this;
    }
    
    /**
     * @return int
     */
    public function getParameterType()
    {
        return $this->parameterType;
    }
    
    /**
     * @return string
     */
    public function __toString()
    {
        try {
            return (string) $this->toSQL();
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }
    }
    
    /**
     * @return string
     */
    public function toSQL()
    {
        switch ($this->parameterType) {
            case Parameter::TYPE_NUMERIC:
            case Parameter::TYPE_BOOLEAN:
                return (integer) $this->parameter;
            default:
                return $this->escape($this->parameter, $this->parameterType);
        }
    }
    
    
}
