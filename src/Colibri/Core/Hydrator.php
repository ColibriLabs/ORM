<?php

namespace Colibri\Core;

/**
 * Class Hydrator
 * @package Colibri\Core
 */
abstract class Hydrator implements HydratorInterface
{
    
    /**
     * @var \ReflectionClass
     */
    protected $reflection;
    
    /**
     * Hydrator constructor.
     *
     * @param \ReflectionClass $reflection
     */
    public function __construct(\ReflectionClass $reflection)
    {
        $this->reflection = $reflection;
    }
    
    /**
     * @return \ReflectionClass
     */
    public function getReflection()
    {
        return $this->reflection;
    }
    
}