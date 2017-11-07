<?php

namespace Colibri\Query\Expr\Func;

use Colibri\Query\Expr\Func;
use Colibri\Exception\BadCallMethodException;

/**
 * Class Count
 * @package Colibri\Query\Expr\Func
 */
class Count extends Func
{
  
  private $isDistinct = false;
  
  /**
   * Count constructor.
   * MySQL Function COUNT
   *
   * @throws BadCallMethodException
   * @param string $columnName
   * @param bool $isDistinct
   */
  public function __construct($columnName, $isDistinct = false)
  {
    parent::__construct('COUNT', [$columnName]);
    
    $this->setDistinct($isDistinct);
  }
  
  /**
   * @return bool
   */
  public function isDistinct()
  {
    return $this->isDistinct;
  }
  
  /**
   * @param bool $isDistinct
   * @return $this
   */
  public function setDistinct($isDistinct)
  {
    $this->isDistinct = (boolean)$isDistinct;
    
    return $this;
  }
  
  /**
   * @inheritDoc
   */
  protected function toStringFunctionArguments()
  {
    $arguments = parent::toStringFunctionArguments();
    
    if (true === $this->isDistinct()) {
      $arguments = sprintf('DISTINCT %s', $arguments);
    }
    
    return $arguments;
  }
  
}
