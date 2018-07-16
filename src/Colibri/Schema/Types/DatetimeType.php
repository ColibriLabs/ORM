<?php

namespace Colibri\Schema\Types;

use Colibri\Common\DateTime;

/**
 * Class DatetimeType
 *
 * @package Colibri\Schema\Types
 */
class DatetimeType extends Type
{
    
    /**
     * @param $value
     *
     * @return mixed
     */
    public function toPhpValue($value)
    {
        return $this->toDateTimeObject($value);
    }
    
    /**
     * @param $value
     *
     * @return \DateTime|null
     */
    private function toDateTimeObject($value)
    {
        $datetime = null;
        
        switch (true) {
            case $value instanceof \DateTime:
                $datetime = new DateTime($value->format(\DateTime::RFC3339));
                break;
            case is_numeric($value):
                $datetime = new DateTime(sprintf('@%d', $value));
                break;
            case is_string($value):
                $datetime = new DateTime($value);
                break;
        }
        
        return $datetime;
    }
    
    /**
     * @param $value
     *
     * @return mixed
     */
    public function toPlatformValue($value)
    {
        $datetime = $this->toDateTimeObject($value);
        $format = $this->getFormat();
        
        if (strpos($format, '%') !== false) {
            return strftime($format, $datetime->getTimestamp());
        }
        
        return $datetime->format($format);
    }
    
    /**
     * @return string
     */
    private function getFormat()
    {
        $extraData = $this->getExtra();
        
        return is_array($extraData) && isset($extraData['format']) ? $extraData['format'] : 'Y-m-d H:i:s';
    }
    
    /**
     * @inheritDoc
     */
    public function getName()
    {
        return static::DATETIME;
    }
    
}