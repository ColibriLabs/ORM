<?php

namespace Colibri\Common;

use Colibri\Exception\BadArgumentException;

/**
 * Class ObjectIdentity
 * @package Colibri\Common
 */
final class ObjectIdentity
{
    
    /**
     * @var string
     */
    private $identifier = null;
    
    /**
     * @var string
     */
    private $objectName = null;
    
    /**
     * ObjectIdentity constructor.
     *
     * @param string $identifier
     * @param string $objectName
     */
    public function __construct($identifier = null, $objectName = null)
    {
        $this->identifier = $identifier;
        $this->objectName = $objectName;
    }
    
    /**
     * @param object $object
     *
     * @return static
     * @throws BadArgumentException
     */
    public static function createFromObject(object $object)
    {
        if ($object instanceof ObjectIdentity) {
            return new static($object->getIdentifier());
        }
        
        $name = get_class($object);
        $hash = static::getObjectHash($object, 'sha256');
        
        $identifier = sprintf('%s@%s', $name, $hash);
        
        return new static($identifier, $name);
    }
    
    /**
     * @param      $object
     * @param null $hashMethod
     *
     * @return string
     */
    public static function getObjectHash($object, $hashMethod = null)
    {
        return $hashMethod === null ? spl_object_hash($object) : hash($hashMethod, spl_object_hash($object));
    }
    
    /**
     * @param ObjectIdentity $objectIdentity
     *
     * @return bool
     */
    public function equals(ObjectIdentity $objectIdentity)
    {
        return $this->getIdentifier() === $objectIdentity->getIdentifier();
    }
    
    /**
     * @return string
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }
    
    /**
     * @return string
     */
    public function getObjectName(): string
    {
        return $this->objectName;
    }
    
}
