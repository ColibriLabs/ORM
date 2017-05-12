<?php

namespace Colibri\Schema\Types;

use Colibri\Exception\NotSupportedException;

/**
 * Class AbstractScalarType
 * @package Colibri\Schema\Types
 */
abstract class AbstractScalarType extends Type
{
  
  /**
   * @param $value
   * @return mixed
   */
  public function toPhpValue($value)
  {
    static::validateScalarValue($value);
    
    return $value;
  }
  
  /**
   * @param $value
   * @return mixed
   */
  public function toPlatformValue($value)
  {
    static::validateScalarValue($value);
    
    return $value;
  }
  
  /**
   * @param $value
   * @throws NotSupportedException
   */
  private static function validateScalarValue($value)
  {
    if (!is_scalar($value)) {
      throw new NotSupportedException('Type handler :name expect only scalar value types', ['name' => static::class]);
    }
  }
  
}