<?php

namespace Colibri\Extension\EventSubscriber;

use Colibri\Collection\Collection;
use Colibri\Core\Event\EntityLifecycleEvent;
use Colibri\Core\ORMEvents;
use Colibri\Extension\AbstractExtension;
use Colibri\Parameters\ParametersCollection;

/**
 * Class ResourceLogger
 * @package Colibri\Extension\EventSubscriber
 */
class ResourceLogger extends AbstractExtension
{
    
    protected $entitiesStates;
    
    /**
     * @inheritDoc
     */
    public function __construct(ParametersCollection $configuration)
    {
        parent::__construct($configuration);
        
        $this->entitiesStates = new Collection();
    }
    
    /**
     * @inheritdoc
     */
    public function getEvents()
    {
        return [ORMEvents::beforePersist, ORMEvents::afterPersist];
    }
    
    /**
     * @inheritdoc
     */
    public function getNameNS()
    {
        return 'resourceLogger';
    }
    
    /**
     * @param EntityLifecycleEvent $event
     */
    public function beforePersist(EntityLifecycleEvent $event)
    {
        $entity = $event->getEntity();
        $states = $this->getEntitiesStates();
        
        $states->set($entity->hashCode(), $entity);
    }
    
    /**
     * @return Collection
     */
    public function getEntitiesStates()
    {
        return $this->entitiesStates;
    }
    
    /**
     * @param EntityLifecycleEvent $event
     */
    public function afterPersist(EntityLifecycleEvent $event)
    {
        $entity = $event->getEntity();
        $states = $this->getEntitiesStates();
        
        if (!$states->has($entity->hashCode())) {
            
        }
    }
    
}