<?php

/************************************************
 * This file is part of ColibriLabs package     *
 * @copyright (c) 2016-2018 Ivan Hontarenko     *
 * @email ihontarenko@gmail.com                 *
 ************************************************/

namespace Colibri\Extension\EventSubscriber;

use Colibri\Common\Inflector;
use Colibri\Core\Event\EntityLifecycleEvent;
use Colibri\Core\Event\FinderExecutionEvent;
use Colibri\Core\Event\MetadataLoadEvent;
use Colibri\Core\Event\OrmEventInterface;
use Colibri\Core\ORMEvents;
use Colibri\EventDispatcher\Event;
use Colibri\EventDispatcher\EventSubscriber;
use Colibri\Logger\Formatter\LineFormatter;
use Colibri\Logger\Handler\Mask\LogLevelMask;
use Colibri\Logger\Handler\StreamRotatedHandler;
use Colibri\Logger\Log;

/**
 * Class RuntimeDebugger
 * @package Colibri\Extension\EventSubscriber
 */
class RuntimeDebugger implements EventSubscriber
{
  
  /**
   * @var Log
   */
  protected $logger;
  
  /**
   * RuntimeDebugger constructor.
   */
  public function __construct()
  {
    $name = 'ORM.Runtime';
    
    $handler = new StreamRotatedHandler('/var/www/logs/lifeCycle.log', LogLevelMask::MASK_DEBUG);
    $handler->setFormatter(new LineFormatter('[:datetime] [:name.:level] :message'));
    
    $this->logger = new Log($name);
    $this->logger->setDatetimeFormat('Y-m-d H:i:s.u P');
    $this->logger->pushHandler('stream', $handler);
  }
  
  /**
   * Destructor
   */
  public function __destruct()
  {
    $this->logger->debug(null);
  }
  
  /**
   * @return array
   */
  public function getEvents(): array
  {
    return [
      ORMEvents::onMetadataLoad,
      ORMEvents::onEntityLoad,
      ORMEvents::beforeFindExecute,
      ORMEvents::beforePersist,
      ORMEvents::beforeRemove,
      ORMEvents::afterFindExecute,
      ORMEvents::afterPersist,
      ORMEvents::afterRemove,
    ];
  }
  
  /**
   * @param Event  $event
   * @param string $eventName
   * @return null|string
   */
  private function formatEventMessage(Event $event, $eventName = null)
  {
    $message = null;
    
    if ($event instanceof OrmEventInterface) {
      switch (true) {
        case ($event instanceof EntityLifecycleEvent):
          $template = "EntityName: %s\nDump: %s";
          $message = sprintf($template,
            $event->getRepository()->getEntityName(), json_encode($event->getEntity()->toArray(), 128));
          break;
        case ($event instanceof MetadataLoadEvent):
          $message = sprintf('Metadata for %s entity loaded', $event->getMetadata()->getEntityClass());
          break;
        case ($event instanceof FinderExecutionEvent):
          $repository = $event->getRepository();
          $query = $event->getSelectQuery();
          $message = sprintf("EntityName: %s\nSQL: (%s)", $repository->getEntityName(), $query->toSQL());
          break;
      }
    }
    
    $eventName = Inflector::underscore($eventName);
    $eventName = strtoupper($eventName);
    
    $separator  = str_repeat('-', 32);
    
    return sprintf("%s\n[%s]\n%s", $separator, $eventName, $message);
  }
  
  /**
   * @param MetadataLoadEvent $metadataEvent
   */
  public function onMetadataLoad(MetadataLoadEvent $metadataEvent)
  {
    $this->logger->debug($this->formatEventMessage($metadataEvent, 'onMetadataLoad'));
  }
  
  /**
   * @param EntityLifecycleEvent $lifecycleEvent
   */
  public function onEntityLoad(EntityLifecycleEvent $lifecycleEvent)
  {
    $this->logger->debug($this->formatEventMessage($lifecycleEvent, 'onEntityLoad'));
  }
  
  /**
   * @param FinderExecutionEvent $executionEvent
   */
  public function beforeFindExecute(FinderExecutionEvent $executionEvent)
  {
    $this->logger->debug($this->formatEventMessage($executionEvent, 'beforeFindExecute'));
  }
  
  /**
   * @param EntityLifecycleEvent $lifecycleEvent
   */
  public function beforePersist(EntityLifecycleEvent $lifecycleEvent)
  {
    $this->logger->debug($this->formatEventMessage($lifecycleEvent, 'beforePersist'));
  }
  
  /**
   * @param EntityLifecycleEvent $lifecycleEvent
   */
  public function beforeRemove(EntityLifecycleEvent $lifecycleEvent)
  {
    $this->logger->debug($this->formatEventMessage($lifecycleEvent, 'beforeRemove'));
  }
  
  /**
   * @param FinderExecutionEvent $executionEvent
   */
  public function afterFindExecute(FinderExecutionEvent $executionEvent)
  {
    $this->logger->debug($this->formatEventMessage($executionEvent, 'afterFindExecute'));
  }
  
  /**
   * @param EntityLifecycleEvent $lifecycleEvent
   */
  public function afterPersist(EntityLifecycleEvent $lifecycleEvent)
  {
    $this->logger->debug($this->formatEventMessage($lifecycleEvent, 'afterPersist'));
  }
  
  /**
   * @param EntityLifecycleEvent $lifecycleEvent
   */
  public function afterRemove(EntityLifecycleEvent $lifecycleEvent)
  {
    $this->logger->debug($this->formatEventMessage($lifecycleEvent, 'afterRemove'));
  }
  
  /**
   * @return Log
   */
  public function getLogger(): Log
  {
    return $this->logger;
  }
  
}