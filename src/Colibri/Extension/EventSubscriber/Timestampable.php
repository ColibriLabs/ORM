<?php

namespace Colibri\Extension\EventSubscriber;

use Colibri\Common\DateTime;
use Colibri\Core\Domain\EntityInterface;
use Colibri\Core\Event\EntityLifecycleEvent;
use Colibri\Core\ORMEvents;
use Colibri\Core\Repository;
use Colibri\Extension\AbstractExtension;
use Colibri\Extension\ExtensionException;
use Colibri\Parameters\ParametersCollection;

/**
 * Class Timestampable
 * @package Colibri\Extension\EventSubscriber
 */
class Timestampable extends AbstractExtension
{
    
    const ON_CREATE = 'create';
    const ON_UPDATE = 'update';
    
    /**
     * @inheritDoc
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
        return 'timestampable';
    }
    
    /**
     * @param EntityLifecycleEvent $event
     *
     * @return void
     */
    public function beforePersist(EntityLifecycleEvent $event)
    {
        foreach ($this->getConfiguration() as $entityClassName => $propertyConfiguration) {
            if ($event->getEntity() instanceof $entityClassName) {
                /** @var Repository $repository */
                $entity = $event->getEntity();
                $repository = $event->getRepository();
                foreach ($propertyConfiguration as $propertyName => $configuration) {
                    $this->updateEntity($propertyName, $entity, $repository, $configuration);
                }
            }
        }
    }
    
    /**
     * @param                      $property
     * @param EntityInterface      $entity
     * @param Repository           $repository
     * @param ParametersCollection $configuration
     *
     * @return null
     * @throws ExtensionException
     */
    private function updateEntity($property, EntityInterface $entity, Repository $repository, ParametersCollection $configuration)
    {
        if ($configuration->offsetExists('on') && $onEvent = $configuration->offsetGet('on')) {
            
            $onEvent = !static::isIterable($onEvent) ? [$onEvent] : $onEvent;
            
            foreach ($onEvent as $onEventName) {
                if (($onEventName === Timestampable::ON_CREATE && $repository->isNewEntity($entity)) || $onEventName === Timestampable::ON_UPDATE) {
                    $entity->setByProperty($property, new DateTime());
                }
            }
            
            return null;
        }
        
        throw new ExtensionException('Wrong configuration passed to Timestampable extension');
    }
    
}