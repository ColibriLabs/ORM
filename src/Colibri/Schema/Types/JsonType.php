<?php

namespace Colibri\Schema\Types;

/**
 * Class JsonType
 *
 * @package Colibri\Schema\Types
 */
class JsonType extends StringType
{
  
  /**
   * @inheritdoc
   */
  public function toPhpValue($value)
  {
    return json_decode($value);
  }

  /**
   * @inheritdoc
   */
  public function toPlatformValue($value)
  {
    return parent::toPlatformValue(json_encode($value, JSON_PRETTY_PRINT));
  }
  
  /**
   * @inheritDoc
   */
  public function getName()
  {
    return static::JSON;
  }
  
}