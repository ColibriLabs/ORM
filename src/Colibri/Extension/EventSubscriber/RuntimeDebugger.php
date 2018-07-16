<?php

/************************************************
 * This file is part of ColibriLabs package     *
 * @copyright (c) 2016-2018 Ivan Hontarenko     *
 * @email ihontarenko@gmail.com                 *
 ************************************************/

namespace Colibri\Extension\EventSubscriber;

use Colibri\Common\ArrayableInterface;
use Colibri\Common\StringableInterface;
use Colibri\Core\Domain\EntityInterface;
use Colibri\Core\Domain\MetadataInterface;
use Colibri\Core\Event\EntityLifecycleEvent;
use Colibri\Core\Event\FinderExecutionEvent;
use Colibri\Core\Event\MetadataLoadEvent;
use Colibri\Core\Event\OrmEventInterface;
use Colibri\Core\ORMEvents;
use Colibri\Core\ProxyInterface;
use Colibri\EventDispatcher\Event;
use Colibri\Extension\AbstractExtension;
use Colibri\Logger\Formatter\LineFormatter;
use Colibri\Logger\Handler\Mask\LogLevelMask;
use Colibri\Logger\Handler\StreamRotatedHandler;
use Colibri\Logger\Log;

/**
 * Class RuntimeDebugger
 * @package Colibri\Extension\EventSubscriber
 */
class RuntimeDebugger extends AbstractExtension implements ProxyInterface
{
    
    /**
     * @var Log
     */
    protected $logger;
    
    /**
     * @var bool
     */
    protected $isInitialized = false;
    
    /**
     * Destructor
     */
    public function __destruct()
    {
        $this->debug(null);
    }
    
    /**
     * @param       $message
     * @param array $context
     */
    public function debug($message, array $context = [])
    {
        $this->initialize();
        
        $this->logger->debug($message, $context);
    }
    
    /**
     * @inheritDoc
     */
    public function initialize()
    {
        if ($this->isInitialized() === false) {
            $configuration = $this->getConfiguration();
            
            $handler = new StreamRotatedHandler($configuration->get('streamFilename'), LogLevelMask::MASK_DEBUG);
            $handler->setFormatter(new LineFormatter($configuration->get('logFormat')));
            
            $this->logger = new Log($configuration->get('prefixName'));
            $this->logger->setDatetimeFormat($configuration->get('datetimeFormat'));
            $this->logger->pushHandler('stream', $handler);
            
            $this->isInitialized = true;
        }
    }
    
    /**
     * @inheritDoc
     */
    public function isInitialized()
    {
        return $this->isInitialized;
    }
    
    /**
     * @inheritDoc
     */
    public function getNameNS()
    {
        return 'runtimeDebugger';
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
     * @param MetadataLoadEvent $metadataEvent
     */
    public function onMetadataLoad(MetadataLoadEvent $metadataEvent)
    {
        $this->debug($this->formatEventMessage($metadataEvent));
    }
    
    /**
     * @param Event $event
     *
     * @return null|string
     */
    private function formatEventMessage(Event $event)
    {
        $message = null;
        $entityName = null;
        
        if ($event instanceof OrmEventInterface) {
            switch (true) {
                case ($event instanceof EntityLifecycleEvent):
                    $entityName = $event->getRepository()->getEntityName();
                    $message = $this->entityToString($event->getEntity());
                    break;
                case ($event instanceof MetadataLoadEvent):
                    $message = $this->metadataToString($event->getMetadata());
                    $entityName = $event->getMetadata()->getEntityClass();
                    break;
                case ($event instanceof FinderExecutionEvent):
                    $entityName = $event->getRepository()->getEntityName();
                    $query = $event->getSelectQuery();
                    $message = sprintf("SQL: (%s)", str_replace("\n", "\x20", $query->toSQL()));
                    break;
            }
        }
        
        $eventName = sprintf('%s::%s', (new \ReflectionObject($event))->getShortName(), $event->getName());
        $separator = str_repeat('-', 32);
        
        return sprintf("%s\n[%s]\nEntityClassName: %s\n%s", $separator, $eventName, $entityName, $message);
    }
    
    /**
     * @param EntityInterface $entity
     *
     * @return string
     */
    private function entityToString(EntityInterface $entity)
    {
        $template = "Values: %s";
        $entityValues = null;
        
        foreach ($entity->toArray() as $propertyName => $propertyValue) {
            $entityValues = sprintf("%s\n\t%s = '%s'", $entityValues, $propertyName, $this->stringifyValue($propertyValue));
        }
        
        return sprintf($template, $entityValues);
    }
    
    /**
     * @param $value
     *
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
                $value = sprintf('Arrayable::%s (%s)', (new \ReflectionObject($value))->getShortName(),
                    $this->stringifyValue($value->toArray()));
                break;
            case is_scalar($value):
            case method_exists($value, '__toString'):
                $value = (string) $value;
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
     * @param MetadataInterface $metadata
     *
     * @return string
     */
    private function metadataToString(MetadataInterface $metadata)
    {
        $string = "Metadata:";
        $defaults = $metadata->getColumnsDefaultValues();
        
        foreach ($metadata->getNames() as $columnName) {
            $string = sprintf("%s\n%s:\n\tPRIMARY=%s, UNSIGNED=%s, NULLABLE=%s, DEFAULT=%s",
                $string, $columnName,
                $metadata->isPrimary($columnName) ? 'Y' : 'N',
                $metadata->isNullable($columnName) ? 'Y' : 'N',
                $metadata->isUnsigned($columnName) ? 'Y' : 'N',
                $this->stringifyValue($defaults[$columnName] ?? null)
            );
        }
        
        return $string;
    }
    
    /**
     * @param EntityLifecycleEvent $lifecycleEvent
     */
    public function onEntityLoad(EntityLifecycleEvent $lifecycleEvent)
    {
        $this->debug($this->formatEventMessage($lifecycleEvent));
    }
    
    /**
     * @param FinderExecutionEvent $executionEvent
     */
    public function beforeFindExecute(FinderExecutionEvent $executionEvent)
    {
        $this->debug($this->formatEventMessage($executionEvent));
    }
    
    /**
     * @param EntityLifecycleEvent $lifecycleEvent
     */
    public function beforePersist(EntityLifecycleEvent $lifecycleEvent)
    {
        $this->debug($this->formatEventMessage($lifecycleEvent));
    }
    
    /**
     * @param EntityLifecycleEvent $lifecycleEvent
     */
    public function beforeRemove(EntityLifecycleEvent $lifecycleEvent)
    {
        $this->debug($this->formatEventMessage($lifecycleEvent));
    }
    
    /**
     * @param FinderExecutionEvent $executionEvent
     */
    public function afterFindExecute(FinderExecutionEvent $executionEvent)
    {
        $this->debug($this->formatEventMessage($executionEvent));
    }
    
    /**
     * @param EntityLifecycleEvent $lifecycleEvent
     */
    public function afterPersist(EntityLifecycleEvent $lifecycleEvent)
    {
        $this->debug($this->formatEventMessage($lifecycleEvent));
    }
    
    /**
     * @param EntityLifecycleEvent $lifecycleEvent
     */
    public function afterRemove(EntityLifecycleEvent $lifecycleEvent)
    {
        $this->debug($this->formatEventMessage($lifecycleEvent));
    }
    
    /**
     * @return Log
     */
    public function getLogger(): Log
    {
        return $this->logger;
    }
    
}