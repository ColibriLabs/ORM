<?php

namespace Colibri\Query\Statement\Join;

use Colibri\Query\Builder;
use Colibri\Query\Expr\Subquery;
use Colibri\Query\Expression;
use Colibri\Query\Statement\AbstractStatement;
use Colibri\Query\Statement\Comparison\Comparison;
use Colibri\Query\Statement\Joins;
use Colibri\Query\Statement\Where;

/**
 * Class Join
 * @package Colibri\Query\Statement
 */
class Join extends AbstractStatement
{
    
    const TEMPLATE = "%s JOIN %s ON (%s)";
    
    /**
     * @var string
     */
    protected $joinType = Joins::INNER;
    
    /**
     * @var Expression
     */
    protected $foreign = null;
    
    /**
     * @var Where
     */
    protected $on = null;
    
    /**
     * AbstractStatement constructor.
     *
     * @param Builder    $builder
     * @param Expression $foreign
     * @param Where      $on
     * @param            $joinType
     */
    public function __construct(Builder $builder, Expression $foreign, Where $on, $joinType = Joins::INNER)
    {
        parent::__construct($builder);
        
        $this->joinType = $joinType;
        $this->foreign = $foreign;
        $this->on = $on;
    }
    
    /**
     * @return string
     */
    public function toSQL()
    {
        $on = [];
        foreach ($this->getOn()->getConditionsArrayCopy() as $index => $criteria) {
            /** @var Comparison $criterion */
            $criterion = $criteria['condition'];
            $conjunction = $criteria['conjunction'];
            $on[] = ($index > 0 ? " $conjunction " : null) . $criterion->toSQL();
        }
        
        return sprintf(
            static::TEMPLATE,
            $this->getJoinType(),
            $this->buildExpression($this->getForeign()),
            implode($on)
        );
    }
    
    /**
     * @return Where
     */
    public function getOn()
    {
        return $this->on;
    }
    
    /**
     * @return string
     */
    public function getJoinType()
    {
        return $this->joinType;
    }
    
    /**
     * @param Expression $expression
     *
     * @return string
     */
    protected function buildExpression(Expression $expression)
    {
        $template = $expression instanceof Subquery ? '(%s)' : '%s';
        $expressionString = $this->stringifyExpression($expression);
        
        return trim(sprintf($template, $expressionString));
    }
    
    /**
     * @return Expression
     */
    public function getForeign()
    {
        return $this->foreign;
    }
    
}
