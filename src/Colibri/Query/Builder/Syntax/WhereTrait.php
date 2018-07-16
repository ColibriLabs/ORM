<?php

namespace Colibri\Query\Builder\Syntax;

use Colibri\Exception\BadArgumentException;
use Colibri\Exception\BadCallMethodException;
use Colibri\Query\Expr;
use Colibri\Query\Expression;
use Colibri\Query\Statement\Comparison\Cmp;
use Colibri\Query\Statement\Comparison\Comparison;
use Colibri\Query\Statement\Where;


/**
 * Class WhereTrait
 * @package Colibri\Query\Builder\Syntax
 */
trait WhereTrait
{
    
    /**
     * @return Where
     * @throws BadArgumentException
     */
    abstract public function getWhereStatement();
    
    /**
     * @return $this
     */
    public function clearWhereConditions()
    {
        $this->getWhereStatement()->getExpressions()->clear();
        
        return $this;
    }
    
    /**
     * @return Where
     */
    public function newWhereInstance()
    {
        return $this->getWhereStatement()->newInstance();
    }
    
    /**
     * @param string $conjunction
     *
     * @return Where
     */
    public function subWhere($conjunction = Cmp::CONJUNCTION_AND)
    {
        return $this->getWhereStatement()->subWhere($conjunction);
    }
    
    /**
     * @param string $conjunction
     *
     * @return Where
     */
    public function sub($conjunction = Cmp::CONJUNCTION_AND)
    {
        return $this->subWhere($conjunction);
    }
    
    /**
     * @param array ...$parameters
     *
     * @return $this
     */
    public function addConditions(...$parameters)
    {
        if (count($parameters) > 0) {
            if (is_array($parameters[0])) {
                foreach ($parameters as $parameter) {
                    $this->addConditions(...$parameter);
                }
            } else {
                if (!isset($parameters[2])) {
                    $parameters[2] = Comparison::determineComparison($parameters[1]);
                }
                
                $parameters[1] = is_array($parameters[1]) ? new Expr\Parameters($parameters[1]) : $parameters[1];
                $this->where(...$parameters);
            }
        }
        
        return $this;
    }
    
    /**
     * @param        $left
     * @param        $right
     * @param        $comparator
     * @param string $conjunction
     *
     * @return $this
     */
    public function where($left, $right, $comparator = Cmp::EQ, $conjunction = Cmp::CONJUNCTION_AND)
    {
        $left = ($left instanceof Expression) ? $left : new Expr\Column($left);
        $right = ($right instanceof Expression) ? $right : new Expr\Parameter($right);
        
        return $this->condition($left, $right, $comparator, $conjunction);
    }
    
    /**
     * @param Expression $left
     * @param Expression $right
     * @param            $comparator
     * @param string     $conjunction
     *
     * @return $this
     */
    public function condition(Expression $left, Expression $right, $comparator, $conjunction = Cmp::CONJUNCTION_AND)
    {
        $this->getWhereStatement()->add($left, $right, $comparator, $conjunction);
        
        return $this;
    }
    
    /**
     * @param       $column
     * @param array $data
     *
     * @return $this
     */
    public function whereNotIn($column, array $data = [])
    {
        return $this->where($column, $data, Cmp::NOT_IN);
    }
    
    /**
     * @param string|Expr\Raw $raw
     *
     * @return $this
     */
    public function whereRaw($raw)
    {
        return $this->where(($raw instanceof Expr\Raw) ? $raw : new Expr\Raw($raw), null, Cmp::RAW);
    }
    
    /**
     * @param $column
     *
     * @return $this
     */
    public function isNull($column)
    {
        return $this->whereIsNull($column);
    }
    
    /**
     * @param $column
     *
     * @return $this
     */
    public function whereIsNull($column)
    {
        return $this->where($column, null, Cmp::IS_NULL);
    }
    
    /**
     * @param $column
     *
     * @return $this
     */
    public function isNotNull($column)
    {
        return $this->whereNotIsNull($column);
    }
    
    /**
     * @param $column
     *
     * @return $this
     */
    public function whereNotIsNull($column)
    {
        return $this->where($column, null, Cmp::NOT_IS_NULL);
    }
    
    /**
     * @param      $column
     * @param null $value
     *
     * @return $this
     * @throws BadCallMethodException
     */
    public function eq($column, $value = null)
    {
        return $this->where($column, $value, Cmp::EQ);
    }
    
    /**
     * @param      $column
     * @param null $value
     *
     * @return $this
     * @throws BadCallMethodException
     */
    public function gt($column, $value = null)
    {
        return $this->where($column, $value, Cmp::GT);
    }
    
    /**
     * @param      $column
     * @param null $value
     *
     * @return $this
     * @throws BadCallMethodException
     */
    public function lt($column, $value = null)
    {
        return $this->where($column, $value, Cmp::LT);
    }
    
    /**
     * @param      $column
     * @param null $value
     *
     * @return $this
     * @throws BadCallMethodException
     */
    public function gte($column, $value = null)
    {
        return $this->where($column, $value, Cmp::GTE);
    }
    
    /**
     * @param      $column
     * @param null $value
     *
     * @return $this
     * @throws BadCallMethodException
     */
    public function lte($column, $value = null)
    {
        return $this->where($column, $value, Cmp::LTE);
    }
    
    /**
     * @param      $column
     * @param null $data
     *
     * @return $this
     */
    public function in($column, $data = null)
    {
        return $this->whereIn($column, $data);
    }
    
    /**
     * @param string $column
     * @param mixed  $expression
     *
     * @return $this
     */
    public function whereIn($column, $expression)
    {
        if (is_array($expression)) {
            $expression = new Expr\Parameters($expression);
        }
        
        return $this->where(new Expr\Column($column), $expression, Cmp::IN);
    }
    
}
