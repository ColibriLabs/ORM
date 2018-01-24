<?php

namespace Colibri\Query;

use Colibri\Query\Builder\Common;
use Colibri\Query\Builder\Select;
use Colibri\Query\Builder\Syntax\GroupByTrait;
use Colibri\Query\Builder\Syntax\HavingTrait;
use Colibri\Query\Builder\Syntax\JoinTrait;
use Colibri\Query\Builder\Syntax\LimitTrait;
use Colibri\Query\Builder\Syntax\ModifiersTrait;
use Colibri\Query\Builder\Syntax\OrderByTrait;
use Colibri\Query\Builder\Syntax\WhereTrait;
use Colibri\ServiceContainer\ServiceLocator;

/**
 * Proxy Class For Select Query Builder
 *
 * Class Criteria
 * @package Colibri\Query
 */
class Criteria
{

  use Common\BaseBuilderTrait, Common\SelectTrait;
  use WhereTrait, GroupByTrait, OrderByTrait, ModifiersTrait, HavingTrait, JoinTrait, LimitTrait;
  
  /**
   * @var Builder\Select
   */
  protected $builder;
  
  /**
   * Criteria constructor.
   */
  public function __construct()
  {
    $this->builder = new Select(ServiceLocator::instance()->getConnection());
  }
  
  /**
   * @inheritDoc
   */
  public function getBuilderObject()
  {
    return $this->builder;
  }
  
  /**
   * @inheritDoc
   */
  public function getSelectBuilderObject()
  {
    return $this->builder;
  }
  
  /**
   * @inheritDoc
   */
  public function getGroupByStatement()
  {
    return $this->builder->getGroupByStatement();
  }
  
  /**
   * @inheritDoc
   */
  public function getHavingStatement()
  {
    return $this->builder->getHavingStatement();
  }
  
  /**
   * @inheritDoc
   */
  public function getJoinStatement()
  {
    return $this->builder->getJoinStatement();
  }
  
  /**
   * @inheritDoc
   */
  public function getLimitStatement()
  {
    return $this->builder->getLimitStatement();
  }
  
  /**
   * @inheritDoc
   */
  public function getModifiersStatement()
  {
    return $this->builder->getModifiersStatement();
  }
  
  /**
   * @inheritDoc
   */
  public function getOrderByStatement()
  {
    return $this->builder->getOrderByStatement();
  }
  
  /**
   * @inheritDoc
   */
  public function getWhereStatement()
  {
    return $this->builder->getWhereStatement();
  }
  
}