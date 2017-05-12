<?php

namespace Colibri\Query\Statement;

use Colibri\Query\Builder\Syntax;

/**
 * Class Limit
 * @package Colibri\Query\Statement
 */
class Limit extends AbstractStatement
{

  use Syntax\LimitTrait;

  /**
   * @var int
   */
  protected $limit = 0;

  /**
   * @var int
   */
  protected $offset = 0;
  
  /**
   * @var bool
   */
  protected $limitOnly = false;

  /**
   * @return int
   */
  public function getLimit()
  {
    return $this->limit;
  }

  /**
   * @param int $limit
   */
  public function setLimit($limit)
  {
    $this->limit = $limit;
  }

  /**
   * @return int
   */
  public function getOffset()
  {
    return $this->offset;
  }

  /**
   * @param int $offset
   */
  public function setOffset($offset)
  {
    $this->offset = $offset;
  }

  /**
   * @return string
   */
  public function toSQL()
  {
    return $this->getLimit() > 0
      ? ($this->isLimitOnly() ? $this->getLimit() : sprintf('%d, %d', $this->getOffset(), $this->getLimit()))
      : null;
  }

  /**
   * @return Limit
   */
  public function getLimitStatement()
  {
    return $this;
  }
  
  /**
   * @return boolean
   */
  public function isLimitOnly()
  {
    return $this->limitOnly;
  }
  
  /**
   * @param boolean $limitOnly
   */
  public function setLimitOnly($limitOnly)
  {
    $this->limitOnly = $limitOnly;
  }
  
}