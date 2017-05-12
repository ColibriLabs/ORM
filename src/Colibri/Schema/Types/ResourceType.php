<?php

namespace Colibri\Schema\Types;

/**
 * Class ResourceType
 *
 * @package Colibri\Schema\Types
 */
class ResourceType extends Type
{
  
  /**
   * @inheritDoc
   */
  public function toPhpValue($value)
  {
    return $value;
  }
  
  /**
   * @inheritDoc
   */
  public function toPlatformValue($value)
  {
    return $value;
  }
  
  /**
   * @inheritDoc
   */
  public function getName()
  {
    return static::BINARY;
  }
  
}