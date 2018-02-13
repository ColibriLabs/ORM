<?php

namespace Colibri\Extension\EventSubscriber;

use Colibri\Core\Event\EntityLifecycleEvent;
use Colibri\Core\ORMEvents;
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
    $lifecycleEvent->getQueryOfAction();
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