<?php

namespace Colibri\Schema\Types;

/**
 * Class SimpleArrayType
 *
 * @package Colibri\Schema\Types
 */
class SimpleArrayType extends Type
{
    
    const DEFAULT_SEPARATOR = ':';
    
    /**
     * @inheritDoc
     */
    public function toPhpValue($value)
    {
        return explode($this->getSeparator(), $value);
    }
    
    /**
     * @return string
     */
    public function getSeparator()
    {
        $extra = $this->getExtra();
        
        if (isset($extra['separator'])) {
            return $extra['separator'];
        }
        
        return self::DEFAULT_SEPARATOR;
    }
    
    /**
     * @inheritDoc
     */
    public function toPlatformValue($value)
    {
        return implode($this->getSeparator(), is_array($value) ? $value : [$value]);
    }
    
    /**
     * @inheritDoc
     */
    public function getName()
    {
        return static::ARRAY_LIST;
    }
    
}