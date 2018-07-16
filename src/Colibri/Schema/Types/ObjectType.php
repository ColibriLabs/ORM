<?php

namespace Colibri\Schema\Types;

/**
 * Class ObjectType
 *
 * @package Colibri\Schema\Types
 */
class ObjectType extends Type
{
    
    /**
     * @param $value
     *
     * @return mixed
     */
    public function toPhpValue($value)
    {
        return unserialize($value);
    }
    
    /**
     * @param $value
     *
     * @return mixed
     */
    public function toPlatformValue($value)
    {
        return serialize($value);
    }
    
    /**
     * @inheritDoc
     */
    public function getName()
    {
        return static::OBJECT;
    }
    
}