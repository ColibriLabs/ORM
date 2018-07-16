<?php

namespace Colibri\Core\Hydrator;

use Colibri\Core\Hydrator;

/**
 * Class HydratorProperty
 * @package Colibri\Core\Hydrator
 */
class HydratorProperty extends Hydrator
{
    
    /**
     * @var int
     */
    protected $accessLevel = \ReflectionProperty::IS_PRIVATE;
    
    /**
     * HydratorProperty constructor.
     *
     * @param \ReflectionClass $reflection
     * @param int              $accessLevel
     */
    public function __construct(\ReflectionClass $reflection, $accessLevel = \ReflectionProperty::IS_PRIVATE)
    {
        parent::__construct($reflection);
        
        $this->accessLevel = $accessLevel;
    }
    
    /**
     * @inheritDoc
     */
    public function hydrate(array $data, $object)
    {
        foreach ($this->getReflection()->getProperties($this->getAccessLevel()) as $property) {
            if (isset($data[$property->getName()])) {
                $property->setAccessible(true);
                $property->setValue($object, $data[$property->getName()]);
            }
        }
        
        return $object;
    }
    
    /**
     * @return int
     */
    public function getAccessLevel()
    {
        return $this->accessLevel;
    }
    
    /**
     * @inheritDoc
     */
    public function extract($object)
    {
        $collection = [];
        
        foreach ($this->getReflection()->getProperties($this->getAccessLevel()) as $property) {
            $collection[$property->getName()] = $property->getValue($object);
        }
        
        return $collection;
    }
    
}