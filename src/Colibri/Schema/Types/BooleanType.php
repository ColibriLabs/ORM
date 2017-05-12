<?php

namespace Colibri\Schema\Types;

/**
 * Class BooleanType
 * @package Colibri\Schema\Types
 */
class BooleanType extends IntegerType
{
  
  /**
   * @inheritDoc
   */
  public function toPhpValue($value)
  {
    return (boolean) parent::toPhpValue($value);
  }
  
  /**
   * @inheritDoc
   */
  public function getName()
  {
    return static::BOOLEAN;
  }
  
}