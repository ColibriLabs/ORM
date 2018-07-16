<?php

namespace Colibri\Logger\Handler\Mask;

use JsonSerializable;

/**
 * Class AbstractMask
 * @package Colibri\Logger\Handler\Mask
 */
abstract class AbstractMask implements MaskInterface, JsonSerializable
{
    
    /**
     * @var int
     */
    protected $mask = 0;
    
    /**
     * AbstractMask constructor.
     *
     * @param int $mask
     */
    public function __construct($mask = 0)
    {
        $this->set($mask);
    }
    
    /**
     * @param mixed $mask
     *
     * @return $this
     */
    public function set($mask)
    {
        $this->mask = $this->resolve($mask);
        
        return $this;
    }
    
    /**
     * @param int|string $mask
     *
     * @throws \InvalidArgumentException
     * @return int
     */
    public function resolve($mask)
    {
        if (is_string($mask)) {
            if (!defined($name = sprintf(static::class . '::MASK_%s', strtoupper($mask)))) {
                throw new \InvalidArgumentException("Constant do not exists $name");
            }
            
            return constant($name);
        }
        
        if (!is_int($mask)) {
            throw new \InvalidArgumentException("Mask is invalid. Should be an integer");
        }
        
        return $mask;
    }
    
    /**
     * @param $mask
     *
     * @return $this
     */
    public function add($mask)
    {
        $this->mask |= $this->resolve($mask);
        
        return $this;
    }
    
    /**
     * @param int $mask
     *
     * @return MaskInterface
     */
    public function remove($mask)
    {
        // a &= ~ b | a ^= b;
        $this->mask ^= $this->resolve($mask);
        
        return $this;
    }
    
    /**
     * @return MaskInterface
     */
    public function reset()
    {
        $this->mask = 0;
        
        return $this;
    }
    
    /**
     * @param $mask
     *
     * @return bool
     */
    public function has($mask)
    {
        return (boolean) ($this->mask & $this->resolve($mask));
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
        return $this->get();
    }
    
    /**
     * @return int
     */
    public function get()
    {
        return $this->mask;
    }
    
    /**
     * The __toString method allows a class to decide how it will react when it is converted to a string.
     *
     * @return string
     * @link http://php.net/manual/en/language.oop5.magic.php#language.oop5.magic.tostring
     */
    function __toString()
    {
        return (string) $this->get();
    }
    
}