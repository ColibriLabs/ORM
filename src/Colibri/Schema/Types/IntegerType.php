<?php

namespace Colibri\Schema\Types;

/**
 * Class IntegerType
 * @package Colibri\Schema\Types
 */
class IntegerType extends AbstractScalarType
{
    
    /**
     * @inheritDoc
     */
    public function toPhpValue($value)
    {
        return (integer) parent::toPhpValue($value);
    }
    
    /**
     * @inheritDoc
     */
    public function toPlatformValue($value)
    {
        return (integer) parent::toPlatformValue($value);
    }
    
    /**
     * @inheritDoc
     */
    public function getName()
    {
        return static::INTEGER;
    }
    
}