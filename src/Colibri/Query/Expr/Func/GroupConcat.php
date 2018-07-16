<?php

namespace Colibri\Query\Expr\Func;

use Colibri\Query\Expr\Column;
use Colibri\Query\Expr\Func;
use Colibri\Query\Expression;
use Colibri\Query\Statement\OrderBy;

/**
 * Class GroupConcat
 * @package Colibri\Query\Expr\Func
 */
class GroupConcat extends Func
{
    
    /**
     * @var bool
     */
    private $isDistinct = false;
    
    /**
     * @var string
     */
    private $separator;
    
    /**
     * @var Expression
     */
    private $expression;
    
    /**
     * @var string
     */
    private $vector;
    
    /**
     * GroupConcat constructor.
     *
     * @param array ...$parameters
     */
    public function __construct(...$parameters)
    {
        parent::__construct('GROUP_CONCAT', $parameters);
    }
    
    /**
     * @param bool $isDistinct
     *
     * @return $this
     */
    public function setDistinct($isDistinct)
    {
        $this->isDistinct = $isDistinct;
        
        return $this;
    }
    
    /**
     * @param        $expression
     * @param string $vector
     *
     * @return $this
     */
    public function setOrderBy($expression, $vector = OrderBy::ASC)
    {
        if (!($expression instanceof Expression)) {
            $expression = new Column($expression);
        }
        
        $this->setExpression($expression)->setVector($vector);
        
        return $this;
    }
    
    /**
     * @return $this
     */
    public function removeOrderBy()
    {
        $this->vector = $this->expression = null;
        
        return $this;
    }
    
    /**
     * @inheritdoc
     */
    protected function toStringFunctionArguments()
    {
        $arguments = parent::toStringFunctionArguments();
        
        if (true === $this->isDistinct()) {
            $arguments = sprintf('DISTINCT %s', $arguments);
        }
        
        if ($this->getExpression() instanceof Expression) {
            $orderBy = new OrderBy($this->getBuilder());
            $orderBy->order($this->getExpression(), $this->getVector());
            $arguments = sprintf("%s ORDER BY %s", $arguments, $orderBy->toSQL());
        }
        
        if (null !== $this->getSeparator()) {
            $arguments = sprintf("%s SEPARATOR '%s'", $arguments, $this->getSeparator());
        }
        
        return $arguments;
    }
    
    /**
     * @return bool
     */
    public function isDistinct()
    {
        return $this->isDistinct;
    }
    
    /**
     * @return Expression
     */
    public function getExpression()
    {
        return $this->expression;
    }
    
    /**
     * @param Expression $expression
     *
     * @return $this
     */
    public function setExpression(Expression $expression)
    {
        $this->expression = $expression;
        
        return $this;
    }
    
    /**
     * @return string
     */
    public function getVector()
    {
        return $this->vector;
    }
    
    /**
     * @param string $vector
     *
     * @return $this
     */
    public function setVector($vector)
    {
        $this->vector = $vector;
        
        return $this;
    }
    
    /**
     * @return string
     */
    public function getSeparator()
    {
        return $this->separator;
    }
    
    /**
     * @param string $separator
     *
     * @return $this
     */
    public function setSeparator($separator)
    {
        $this->separator = $separator;
        
        return $this;
    }
    
}
