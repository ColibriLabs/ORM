<?php

namespace Colibri\Query\Builder\Syntax;

use Colibri\Exception\BadArgumentException;
use Colibri\Query\Expression;
use Colibri\Query\Statement\Comparison\Cmp;
use Colibri\Query\Statement\Having;
use Colibri\Query\Expr;

/**
 * Class HavingTrait
 * @package Colibri\Query\Builder\Syntax
 */
trait HavingTrait
{
  
  /**
   * @return Having
   * @throws BadArgumentException
   */
  abstract public function getHavingStatement();
  
  /**
   * @param $left
   * @param $right
   * @param string $comparator
   * @param string $conjunction
   * @return $this
   */
  public function having($left, $right, $comparator = Cmp::EQ, $conjunction = Cmp::CONJUNCTION_AND)
  {
    $left   = ($left instanceof Expression)   ? $left   : new Expr\Column($left);
    $right  = ($right instanceof Expression)  ? $right  : new Expr\Parameter($right);
    
    return $this->addHavingCondition($left, $right, $comparator, $conjunction);
  }
  
  /**
   * @return $this
   */
  public function clearHavingConditions()
  {
    $this->getHavingStatement()->getExpressions()->clear();
    
    return $this;
  }
  
  /**
   * @param Expression $left
   * @param Expression $right
   * @param $comparator
   * @param string $conjunction
   * @return $this
   */
  public function addHavingCondition(Expression $left, Expression $right, $comparator, $conjunction = Cmp::CONJUNCTION_AND)
  {
    $this->getHavingStatement()->add($left, $right, $comparator, $conjunction);
    
    return $this;
  }
  
}
