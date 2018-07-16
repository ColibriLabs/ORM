<?php

namespace Colibri\Schema\Types;

/**
 * Class ArrayType
 *
 * @package Colibri\Schema\Types
 */
class ArrayType extends JsonType
{
    
    /**
     * @param $value
     *
     * @return mixed
     */
    public function toPhpValue($value)
    {
        return parent::toPhpValue($value);
    }
    
    /**
     * @param $value
     *
     * @return mixed
     */
    public function toPlatformValue($value)
    {
        return parent::toPlatformValue($value);
    }
    
}