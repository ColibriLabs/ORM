<?php

namespace Colibri\Query\Expr\Func;

use Colibri\Query\Expr\Func;

/**
 * Class GroupConcat
 * @package Colibri\Query\Expr\Func
 */
class GroupConcat extends Func
{
  
  /**
   * @var string
   */
  private $separator;
  
  /**
   * @var string
   */
  private $orderVector;
  
  /**
   * GroupConcat constructor.
   * @param array ...$parameters
   */
  public function __construct(...$parameters)
  {
    parent::__construct('GROUP_CONCAT', $parameters);
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
   * @return $this
   */
  public function setSeparator($separator)
  {
    $this->separator = $separator;
    
    return $this;
  }
  
  /**
   * @return string
   */
  public function getOrderVector()
  {
    return $this->orderVector;
  }
  
  /**
   * @param string $orderVector
   * @return $this
   */
  public function setOrderVector($orderVector)
  {
    $this->orderVector = $orderVector;
  
    return $this;
  }
  
  /**
   * @inheritdoc
   */
  protected function toStringFunctionArguments()
  {
    $arguments = parent::toStringFunctionArguments();
  
    if (null !== $this->getOrderVector()) {
      $arguments = sprintf("%s ORDER BY %s", $arguments, $this->getOrderVector());
    }
  
    if (null !== $this->getSeparator()) {
      $arguments = sprintf("%s SEPARATOR '%s'", $arguments, $this->getSeparator());
    }
    
    return $arguments;
  }
  
}
