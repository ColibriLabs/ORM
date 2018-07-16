<?php

namespace Colibri\Logger;

use JsonSerializable;

/**
 * Class DateTime
 * @package Colibri\Logger
 */
class DateTime extends \DateTime implements JsonSerializable
{
    
    protected $format = parent::COOKIE;
    
    /**
     * The __toString method allows a class to decide how it will react when it is converted to a string.
     *
     * @return string
     * @link http://php.net/manual/en/language.oop5.magic.php#language.oop5.magic.tostring
     */
    function __toString()
    {
        return $this->format($this->format);
    }
    
    /**
     * @return string
     */
    public function getFormat()
    {
        return $this->format;
    }
    
    /**
     * @param string $format
     */
    public function setFormat($format)
    {
        $this->format = $format;
    }
    
    /**
     * Specify data which should be serialized to JSON
     * @link  http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    function jsonSerialize()
    {
        return $this->format($this->format);
    }
    
}