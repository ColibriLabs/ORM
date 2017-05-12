<?php

namespace Colibri\Query\Statement;

use Colibri\Collection\ArrayCollection;
use Colibri\Exception\BadArgumentException;
use Colibri\Query\Builder;
use Colibri\Query\Expression;
use Colibri\Query\Statement\Comparison;
use Colibri\Query\Statement\Comparison\Cmp;

/**
 * Class Where
 * @package Colibri\Query\Statement
 */
class Where extends AbstractStatement
{

  use Builder\Syntax\WhereTrait;

  /**
   * @var ArrayCollection
   */
  protected $conditions;
  
  /**
   * WhereStatement constructor.
   * @param Builder $builder
   */
  public function __construct(Builder $builder)
  {
    parent::__construct($builder);

    $this->conditions = new ArrayCollection();
  }

  /**
   * Clone operations
   */
  public function __clone()
  {

  }

  /**
   * @return array
   */
  public function __debugInfo()
  {
    return [
      'parent' => parent::__debugInfo(),
      'conditions' => $this->conditions->toArray(),
    ];
  }
  
  /**
   * @param string $conjunction
   * @return $this
   */
  public function subWhere($conjunction = Cmp::CONJUNCTION_AND)
  {
    $subWhere = new Where($this->getBuilder());
    
    $this->conditions[] = ['condition' => $subWhere, 'conjunction' => $conjunction,];

    return $subWhere;
  }

  /**
   * @param Expression $left
   * @param Expression $right
   * @param string $comparator
   * @param string $conjunction
   * @return $this
   * @throws BadArgumentException
   */
  public function add(Expression $left, Expression $right, $comparator, $conjunction = Cmp::CONJUNCTION_AND)
  {
    $this->conditions[] = [
      'condition' => $this->getNewCondition($left, $right, $comparator),
      'conjunction' => $conjunction,
    ];

    return $this;
  }

  /**
   * @return Cmp|null
   */
  public function getLastCondition()
  {
    $array = $this->conditions->toArray();
    
    return end($array);
  }

  /**
   * @param Expression $left
   * @param $right
   * @param $comparator
   * @return Comparison\In|Comparison\IsNull|Comparison\Like|Comparison\Logical|Comparison\Custom
   * @throws BadArgumentException
   */
  public function getNewCondition(Expression $left, Expression $right, $comparator)
  {
    switch ($comparator) {

      case Cmp::EQ:
      case Cmp::NEQ:
      case Cmp::NEQA:
      case Cmp::GT:
      case Cmp::GTE:
      case Cmp::LT:
      case Cmp::LTE:
        return new Comparison\Logical($this->getBuilder(), $left, $right, $comparator);

      case Cmp::LIKE:
      case Cmp::NOT_LIKE:
        return new Comparison\Like($this->getBuilder(), $left, $right, $comparator);

      case Cmp::IN:
      case Cmp::NOT_IN:
        return new Comparison\In($this->getBuilder(), $left, $right, $comparator);

      case Cmp::IS_NULL:
      case Cmp::NOT_IS_NULL:
        return new Comparison\IsNull($this->getBuilder(), $left, $right, $comparator);

      case Cmp::RAW:
        return new Comparison\Custom($this->getBuilder(), $left, $right);

      default:
        throw new BadArgumentException('Comparator ":comparator" not defined', [
          'comparator' => $comparator,
        ]);
    }
  }

  /**
   * @return array
   */
  public function getConditionsArrayCopy()
  {
    return $this->conditions->toArray();
  }

  /**
   * @return Where
   * @throws BadArgumentException
   */
  public function getWhereStatement()
  {
    return $this;
  }

  /**
   * @return string
   */
  public function toSQL()
  {
    /**
     * @var Expression $expression
     */
    
    if($this->conditions->exists()) {
      
      $clauses = [];
      foreach($this->conditions as $index => $condition) {
        $expression = $condition['condition'];
        $conjunction = $condition['conjunction'];
  
        $stringCondition = ($index > 0 ? " $conjunction " : null) . ($expression->toSQL());
  
        $clauses[] = $stringCondition;
      }

      return sprintf('(%s)', implode($clauses));
    }

    return null;
  }

}