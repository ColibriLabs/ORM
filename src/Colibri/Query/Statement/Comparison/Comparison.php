<?php

namespace Colibri\Query\Statement\Comparison;

use Colibri\Query\Builder;
use Colibri\Query\Expression;
use Colibri\Query\SqlableInterface;
use Colibri\Query\Statement\Column;
use Colibri\Query\Statement\Func;
use Colibri\Query\Statement\Raw;
use Colibri\Query\Statement\Subquery;
use Colibri\Query\Statement\Table;

/**
 * Class Comparison
 * @package Colibri\Query
 */
abstract class Comparison implements SqlableInterface
{
    
    // Logical Conditions
    const EQ   = '=';
    const NEQ  = '!=';
    const GT   = '>';
    const LT   = '<';
    const GTE  = '>=';
    const LTE  = '<=';
    const NEQA = '<>';
    
    // Like Conditions
    const LIKE     = 'LIKE';
    const NOT_LIKE = 'NOT LIKE';
    
    // In Sets Conditions
    const IN     = 'IN';
    const NOT_IN = 'NOT IN';
    
    // Is Check Conditions
    const IS_NULL     = 'IS';
    const NOT_IS_NULL = 'IS NOT';
    
    // Manually Raw SQL Conditions
    const RAW = 'RAW';
    
    // (a = 1 AND b = 2) OR (c = 3 XOR d = 4)
    const CONJUNCTION_AND = 'AND';
    const CONJUNCTION_OR  = 'OR';
    const CONJUNCTION_XOR = 'XOR';
    
    // (a = 1 && b = 2) || (c = 3 XOR d = 4)
    const CONJUNCTION_AND_ALT = '&&';
    const CONJUNCTION_OR_ALT  = '||';
    
    // et - latin and
    // vel - latin or
    const ET  = self::CONJUNCTION_AND;
    const VEL = self::CONJUNCTION_OR;
    
    /**
     * @var Builder
     */
    protected $builder = null;
    
    /**
     * @var Expression
     */
    protected $leftExpression = null;
    
    /**
     * @var Expression
     */
    protected $rightExpression = null;
    
    /**
     * @var string
     */
    protected $comparator = Comparison::EQ;
    
    /**
     * Comparison constructor.
     *
     * @param Builder    $builder
     * @param Expression $left
     * @param Expression $right
     * @param string     $comparator
     */
    public function __construct(Builder $builder, Expression $left, Expression $right, $comparator = Comparison::EQ)
    {
        $this->builder = $builder;
        $this->leftExpression = $left;
        $this->rightExpression = $right;
        $this->comparator = $comparator;
    }
    
    /**
     * @param $value
     *
     * @return string
     */
    public static function determineComparison($value)
    {
        switch (true) {
            case is_scalar($value): {
                return static::EQ;
            }
            case is_array($value): {
                return static::IN;
            }
            case null === $value: {
                return static::IS_NULL;
            }
            default: {
                return static::RAW;
            }
        }
    }
    
    /**
     * @return array
     */
    public function __debugInfo()
    {
        return [
            'column'     => $this->leftExpression,
            'comparator' => $this->comparator,
            'value'      => $this->rightExpression,
        ];
    }
    
    /**
     * @param Expression $expression
     *
     * @return string
     */
    public function stringifyExpression(Expression $expression)
    {
        return $this->getBuilder()->stringifyExpression($expression);
    }
    
    /**
     * @return Builder
     */
    public function getBuilder()
    {
        return $this->builder;
    }
    
    /**
     * @return Expression
     */
    public function getRightExpression()
    {
        return $this->rightExpression;
    }
    
    /**
     * @return string
     */
    public function getComparator()
    {
        return $this->comparator;
    }
    
    /**
     * @return Expression
     */
    public function getLeftExpression()
    {
        return $this->leftExpression;
    }
    
    /**
     * @return string
     */
    public function __toString()
    {
        return $this->toSQL();
    }
    
    /**
     * @return string
     */
    public function toSQL()
    {
        return $this->buildCondition();
    }
    
    /**
     * @return string
     */
    abstract protected function buildCondition();
    
}