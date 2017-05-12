<?php

namespace Colibri\Schema\Types;

/**
 * Class FloatType
 *
 * @package Colibri\Schema\Types
 */
class FloatType extends AbstractScalarType
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
    return static::FLOAT;
  }
  
}