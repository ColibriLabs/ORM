<?php

namespace Colibri\Extension\EventSubscriber;

use Colibri\Core\Domain\EntityInterface;
use Colibri\Core\Event\EntityLifecycleEvent;
use Colibri\Core\ORMEvents;
use Colibri\Extension\AbstractExtension;
use Colibri\Parameters\ParametersCollection;

/**
 * Class Versionable
 * @package Colibri\Extension\EventSubscriber
 */
class Versionable extends AbstractExtension
{
    
    /**
     * @return array
     */
    public function getEvents()
    {
        return [ORMEvents::beforePersist];
    }
    
    /**
     * @inheritDoc
     */
    public function getNameNS()
    {
        return 'versionable';
    }
    
    /**
     * @param EntityLifecycleEvent $event
     */
    public function beforePersist(EntityLifecycleEvent $event)
    {
        $this->resolveEntities($event, function (EntityInterface $entity, ParametersCollection $parameters) {
            foreach ($parameters->get('properties') as $propertyName) {
                $version = $entity->getByProperty($propertyName);
                $entity->setByProperty($propertyName, $version + 1);
            }
        });
    }
    
}