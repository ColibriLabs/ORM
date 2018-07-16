<?php

namespace Colibri\Core;

use Colibri\Common\ObjectIdentity;
use Colibri\ServiceContainer\ServiceLocatorInterface;

/**
 * Class RepositoryManager
 * @package Colibri\Core
 */
class RepositoryManager
{
    
    /**
     * @var ServiceLocatorInterface
     */
    protected $serviceLocator;
    
    /**
     * RepositoryManager constructor.
     *
     * @param ServiceLocatorInterface $serviceLocator
     */
    public function __construct(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
    }
    
    /**
     * @param $class
     *
     * @return Domain\RepositoryInterface
     */
    public function getRepositoryFor($class)
    {
        $metadata = $this->getMetadataManager()->getMetadataFor($class);
        $repositoryClass = $metadata->getEntityRepositoryClass();
        
        $identity = new ObjectIdentity(sprintf('%s@%s', $repositoryClass, $class));
        
        if (!$this->getClassManager()->hasShared($identity->getIdentifier())) {
            $repository = $this->getClassManager()->createInstanceFor($repositoryClass, ...[$class]);
            $this->getClassManager()->setShared($identity->getIdentifier(), $repository);
        }
        
        return $this->getClassManager()->getShared($identity->getIdentifier());
    }
    
    /**
     * @return MetadataManager
     */
    public function getMetadataManager()
    {
        return $this->getServiceLocator()->getMetadataManager();
    }
    
    /**
     * @return ServiceLocatorInterface
     */
    public function getServiceLocator()
    {
        return $this->serviceLocator;
    }
    
    /**
     * @return ClassManager
     */
    public function getClassManager()
    {
        return $this->getServiceLocator()->getClassManager();
    }
    
}