<?php

namespace Colibri\Extension\EventSubscriber;

use Colibri\Core\Event\EntityLifecycleEvent;
use Colibri\Core\ORMEvents;
use Colibri\Core\Repository\AbstractRepositoryQueryFactory;
use Colibri\Extension\AbstractExtension;

/**
 * Class SoftDeletion
 * @package Colibri\Extension\EventSubscriber
 */
class SoftDeletion extends AbstractExtension
{
    
    /**
     * @param EntityLifecycleEvent $lifecycleEvent
     */
    public function beforeRemove(EntityLifecycleEvent $lifecycleEvent)
    {
        $lifecycleEvent->getRepository()->getQueryFactory();
        $lifecycleEvent->getRepository()->setQueryFactory(new class extends AbstractRepositoryQueryFactory
        {
            
            /**
             * @inheritDoc
             */
            public function createDeleteQuery()
            {
                return parent::createUpdateQuery();
            }
            
        });
    }
    
    /**
     * @return array
     */
    public function getEvents()
    {
        return [ORMEvents::beforeRemove,];
    }
    
    /**
     * @return string
     */
    public function getNameNS()
    {
        return 'softDeletion';
    }
    
}