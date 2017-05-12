<?php

namespace Colibri\Schema\Types;

/**
 * Class DoubleType
 *
 * @package Colibri\Schema\Types
 */
class DoubleType extends AbstractScalarType
{
  
  /**
   * @inheritDoc
   */
  public function toPhpValue($value)
  {
    return round(parent::toPhpValue($value), $this->getPrecision());
  }
  
  /**
   * @inheritDoc
   */
  public function toPlatformValue($value)
  {
    return round(parent::toPlatformValue($value), $this->getPrecision());
  }
  
  /**
   * @inheritDoc
   */
  public function getName()
  {
    return static::DOUBLE;
  }
  
}