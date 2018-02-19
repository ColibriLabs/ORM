<?php

/************************************************
 * This file is part of ColibriLabs package     *
 * @copyright (c) 2016-2018 Ivan Hontarenko     *
 * @email ihontarenko@gmail.com                 *
 ************************************************/

namespace Colibri\Extension\EventSubscriber;

use Colibri\Common\ArrayableInterface;
use Colibri\Common\Inflector;
use Colibri\Common\StringableInterface;
use Colibri\Core\Domain\EntityInterface;
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
   * @param Event $event
   * @param string $eventName
   * @return null|string
   */
  private function formatEventMessage(Event $event, $eventName = null)
  {
    $message = null;
    
    if ($event instanceof OrmEventInterface) {
      switch (true) {
        case ($event instanceof EntityLifecycleEvent):
          $message = $this->entityToString($event->getEntity());
          break;
        case ($event instanceof MetadataLoadEvent):
          $message = sprintf('Metadata for %s entity loaded', $event->getMetadata()->getEntityClass());
          break;
        case ($event instanceof FinderExecutionEvent):
          $query = $event->getSelectQuery();
          $message = sprintf("SQL: (%s)", str_replace("\n", "\x20", $query->toSQL()));
          break;
      }
    }
    
    $eventName = Inflector::underscore($eventName);
    $eventName = strtoupper($eventName);
    
    $separator = str_repeat('-', 32);
    
    return sprintf("%s\n[%s]\n%s", $separator, $eventName, $message);
  }
  
  /**
   * @param EntityInterface $entity
   * @return string
   */
  private function entityToString(EntityInterface $entity)
  {
    $template = "EntityName: %s\nValues: %s";
    
    $entityName = (new \ReflectionObject($entity))->getShortName();
    $entityValues = null;
    
    foreach ($entity->toArray() as $propertyName => $propertyValue) {
      $entityValues = sprintf("%s\n\t%s = '%s'", $entityValues, $propertyName, $this->stringifyValue($propertyValue));
    }
    
    return sprintf($template, $entityName, $entityValues);
  }
  
  /**
   * @param $value
   * @return string
   */
  private function stringifyValue($value)
  {
    switch (true) {
      case $value === null:
        $value = 'NULL';
        break;
      case ($value instanceof \DateTime):
        $value = $value->format(DATE_RFC822);
        break;
      case ($value instanceof StringableInterface):
        $value = $value->toString();
        break;
      case ($value instanceof ArrayableInterface):
        $value  = sprintf('Arrayable::%s (%s)', (new \ReflectionObject($value))->getShortName(),
          $this->stringifyValue($value->toArray()));
        break;
      case is_scalar($value):
      case method_exists($value, '__toString'):
        $value = (string)$value;
        break;
      case is_object($value):
        $value = sprintf('Object (%s)', get_class($value));
        break;
      case is_array($value):
        $value = sprintf('Array (%s)', implode(', ', array_map([$this, 'stringifyValue'], $value)));
        break;
    }
    
    return $value;
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