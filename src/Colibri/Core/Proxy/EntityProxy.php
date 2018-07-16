<?php

namespace Colibri\Core\Proxy;

use Colibri\Core\Domain\EntityInterface;
use Colibri\Core\Domain\RepositoryInterface;
use Colibri\Core\ProxyInterface;

/**
 * Class EntityProxy
 * @package Colibri\Core
 */
class EntityProxy implements ProxyInterface
{
    
    /**
     * @var RepositoryInterface
     */
    protected $repository;
    
    /**
     * @var bool
     */
    protected $initialized = false;
    
    /**
     * @var array
     */
    protected $criteria = [];
    
    /**
     * @var EntityInterface
     */
    protected $entity;
    
    /**
     * EntityProxy constructor.
     *
     * @param RepositoryInterface $repository
     * @param array               $criteria
     */
    public function __construct(RepositoryInterface $repository = null, array $criteria)
    {
        $this->repository = $repository;
        $this->criteria = $criteria;
    }
    
    /**
     * @inheritDoc
     */
    public function initialize()
    {
        if (false === $this->isInitialized()) {
            $this->initialized = true;
            $this->entity = $this->getRepository()->findOne($this->getCriteria());
        }
        
        return $this->getEntity();
    }
    
    /**
     * @return boolean
     */
    public function isInitialized()
    {
        return $this->initialized;
    }
    
    /**
     * @return RepositoryInterface
     */
    public function getRepository()
    {
        return $this->repository;
    }
    
    /**
     * @return array
     */
    public function getCriteria()
    {
        return $this->criteria;
    }
    
    /**
     * @return EntityInterface
     */
    public function getEntity()
    {
        $this->initialize();
        
        return $this->entity;
    }
    
}