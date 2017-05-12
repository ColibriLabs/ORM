<?php

namespace Colibri\Query\Expr;

use Colibri\Exception\BadArgumentException;
use Colibri\Exception\BadCallMethodException;
use Colibri\Query\Expression;

/**
 * Class Parameters
 * @package Colibri\Query\Expr
 */
class Parameters extends Expression
{

  /**
   * @var array
   */
  protected $parameters = [];

  /**
   * Parameters constructor.
   * @param array $parameters
   */
  public function __construct(array $parameters = [])
  {
    $this->setParameters($parameters);
  }

  /**
   * @return Expression[]
   */
  public function getParameters()
  {
    return $this->parameters;
  }

  /**
   * @param array $parameters
   * @return $this
   * @throws BadArgumentException
   */
  public function setParameters($parameters)
  {
    $this->parameters = [];

    foreach ($parameters as $parameter) {
      if (is_scalar($parameter)) {
        if (is_bool($parameter)) {
          $parameter = new Parameter($parameter, Parameter::TYPE_BOOLEAN);
        } else if (is_numeric($parameter) || is_float($parameter) || is_double($parameter)) {
          $parameter = new Parameter($parameter, Parameter::TYPE_NUMERIC);
        } else {
          $parameter = new Parameter($parameter, Parameter::TYPE_STR);
        }
      }

      if (!($parameter instanceof Expression)) {
        throw new BadArgumentException('Bad parameter type');
      }

      $this->parameters[] = $parameter;
    }

    return $this;
  }

  /**
   * @return string
   * @throws BadCallMethodException
   */
  public function toSQL()
  {
    return implode(', ', $this->getParameters());
  }

  /**
   * @return string
   */
  public function __toString()
  {
    return (string)$this->toSQL();
  }

}