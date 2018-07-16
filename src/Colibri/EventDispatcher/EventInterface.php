<?php

namespace Colibri\EventDispatcher;

/**
 * Interface EventInterface
 * @package Colibri\EventDispatcher
 */
interface EventInterface
{
    
    /**
     * @return bool
     */
    public function isStopped(): bool;
    
    /**
     * @return EventInterface
     */
    public function stop(): EventInterface;
    
    /**
     * @return string
     */
    public function getName(): string;
    
    /**
     * @param string $name
     *
     * @return EventInterface
     */
    public function setName(string $name): EventInterface;
    
}