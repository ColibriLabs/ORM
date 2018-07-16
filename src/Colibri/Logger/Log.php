<?php

namespace Colibri\Logger;

use Colibri\Logger\Collection\Collection;
use Colibri\Logger\Handler\HandlerInterface;
use Colibri\Logger\Handler\Mask\LogLevelMask;
use Colibri\Logger\Placeholder\PlaceholderInterface;
use Colibri\Logger\Placeholder\ServerVariablesPlaceholder;
use Colibri\Logger\Placeholder\SystemIdsPlaceholder;
use Psr\Log\AbstractLogger;
use Psr\Log\LoggerInterface;

/**
 * Class Log
 * @package Colibri\Logger
 */
class Log extends AbstractLogger
{
    
    /**
     * @var Collection|HandlerInterface[]
     */
    protected $handlers;
    
    /**
     * @var Collection|PlaceholderInterface[]
     */
    protected $placeholders;
    
    /**
     * @var string
     */
    protected $name;
    
    /**
     * @var string
     */
    protected $datetimeFormat = DATE_ATOM;
    
    /**
     * Log constructor.
     *
     * @param string|null $name
     */
    public function __construct($name = null)
    {
        $this->handlers = new Collection([], HandlerInterface::class);
        $this->placeholders = new Collection([], PlaceholderInterface::class);
        $this->name = $name;
        
        $this->preSetup();
    }
    
    /**
     * @return void
     */
    private function preSetup()
    {
        $this->pushPlaceholder(new SystemIdsPlaceholder());
        $this->pushPlaceholder(new ServerVariablesPlaceholder());
    }
    
    /**
     * @param PlaceholderInterface $placeholder
     *
     * @return $this
     */
    public function pushPlaceholder(PlaceholderInterface $placeholder)
    {
        $className = get_class($placeholder);
        
        $this->placeholders->set($className, $placeholder);
        
        return $this;
    }
    
    /**
     * Logs with an arbitrary level.
     *
     * @param mixed  $level
     * @param string $message
     * @param array  $context
     *
     * @return bool
     */
    public function log($level, $message, array $context = [])
    {
        $record = $this->prepareRecord($level, $message, $context);
        
        $iterator = $this->handlers->getIterator();
        
        while ($iterator->valid()) {
            /** @var HandlerInterface $handler */
            $handler = $iterator->current();
            
            if ($handler->levelAllow($level)) {
                $handler->handle($record);
            }
            
            $iterator->next();
        }
        
        return true;
    }
    
    /**
     * @param       $level
     * @param       $message
     * @param array $context
     *
     * @return Collection
     */
    protected function prepareRecord(string $level, string $message = null, array $context = []): Collection
    {
        $message = new Collection([
            'content' => $message,
            'context' => $context,
        ]);
        
        $datetime = new DateTime();
        $datetime->setFormat($this->getDatetimeFormat());
        
        $record = new Collection([
            'name'         => $this->name,
            'level'        => strtoupper($level),
            'levelBitmask' => new LogLevelMask($level),
            'datetime'     => $datetime,
            'message'      => $message,
        ]);
        
        $this->placeholders->each(function ($name, PlaceholderInterface $placeholder) use ($record) {
            $placeholder->complement($record);
        });
        
        return $record;
    }
    
    /**
     * @return string
     */
    public function getDatetimeFormat(): string
    {
        return $this->datetimeFormat;
    }
    
    /**
     * @param string $datetimeFormat
     */
    public function setDatetimeFormat(string $datetimeFormat)
    {
        $this->datetimeFormat = $datetimeFormat;
    }
    
    /**
     * @param                  $name
     * @param HandlerInterface $handler
     *
     * @return LoggerInterface
     */
    public function pushHandler($name, HandlerInterface $handler): LoggerInterface
    {
        $this->handlers->set($name, $handler);
        
        return $this;
    }
    
}
