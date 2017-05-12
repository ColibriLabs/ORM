<?php

namespace Colibri\Query\Builder\Syntax;

use Colibri\Query\Expr\Subquery;
use Colibri\Query\Expr\Table;
use Colibri\Query\Expression;
use Colibri\Query\Statement\Joins;
use Colibri\Query\Statement;

/**
 * Class JoinTrait
 * @package Colibri\Query\Builder\Syntax
 */
trait JoinTrait
{

  /**
   * @param string|array|Expression $foreign
   * @param array|Statement\Where $on
   * @param string $joinType
   * @return $this
   */
  public function join($foreign, $on, $joinType = Joins::INNER)
  {
    $builder = $this->getJoinStatement()->getBuilder();
    $foreign = is_array($foreign) ? $foreign : [$foreign];
    $foreign[0] = !($foreign[0] instanceof Expression) ? new Table($foreign[0]) : $foreign[0];

    $foreign = $builder->registerExpression(...$foreign);

    if (is_array($on)) {
      $whereOn = new Statement\Where($builder);
      $on = count($on) === count($on, true) ? [$on] : $on;

      foreach($on as $criteria) {
        list($criteria[0], $criteria[1]) = [
          ($criteria[0] instanceof Expression) ? $criteria[0] : $builder->createColumn($criteria[0]),
          ($criteria[1] instanceof Expression) ? $criteria[1] : $builder->createColumn($criteria[1]),
        ];
        $whereOn->where(...$criteria);
      }

      $on = $whereOn;
    }

    $this->addJoin($foreign, $on, $joinType);

    return $this;
  }

  /**
   * @param Subquery $subquery
   * @param $on
   * @param string $joinType
   * @return $this
   */
  public function joinSubquery($subquery, $on, $joinType = Joins::INNER)
  {
    return $this->join($subquery, $on, $joinType);
  }

  /**
   * @param Subquery $subquery
   * @param $on
   * @return $this
   */
  public function leftJoinSubquery($subquery, $on)
  {
    return $this->joinSubquery($subquery, $on, Joins::LEFT);
  }

  /**
   * @param Subquery $subquery
   * @param $on
   * @return $this
   */
  public function rightJoinSubquery(Subquery $subquery, $on)
  {
    return $this->joinSubquery($subquery, $on, Joins::RIGHT);
  }

  /**
   * @param Subquery $subquery
   * @param $on
   * @return $this
   */
  public function innerJoinSubquery(Subquery $subquery, $on)
  {
    return $this->joinSubquery($subquery, $on, Joins::INNER);
  }

  /**
   * @param Subquery $subquery
   * @param $on
   * @return $this
   */
  public function fullOuterJoinSubquery(Subquery $subquery, $on)
  {
    return $this->joinSubquery($subquery, $on, Joins::FULL_OUTER);
  }

  /**
   * @param $foreign
   * @param $on
   * @return $this
   */
  public function leftJoin($foreign, $on)
  {
    return $this->join($foreign, $on, Joins::LEFT);
  }

  /**
   * @param $foreign
   * @param $on
   * @return $this
   */
  public function rightJoin($foreign, $on)
  {
    return $this->join($foreign, $on, Joins::RIGHT);
  }

  /**
   * @param $foreign
   * @param $on
   * @return $this
   */
  public function innerJoin($foreign, $on)
  {
    return $this->join($foreign, $on, Joins::INNER);
  }

  /**
   * @param $foreign
   * @param $on
   * @return $this
   */
  public function fullOuterJoin($foreign, $on)
  {
    return $this->join($foreign, $on, Joins::FULL_OUTER);
  }

  /**
   * @param Expression $foreign
   * @param Statement\Where $on
   * @param string $joinType
   * @return $this
   */
  public function addJoin(Expression $foreign, Statement\Where $on, $joinType = Joins::INNER)
  {
    $this->getJoinStatement()->add($foreign, $on, $joinType);

    return $this;
  }

  /**
   * @return Joins
   */
  abstract public function getJoinStatement();

}