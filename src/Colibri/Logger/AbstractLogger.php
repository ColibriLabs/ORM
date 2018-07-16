<?php

namespace Colibri\Logger;

/**
 * Class AbstractLogger
 * @package Colibri\Logger
 */
abstract class AbstractLogger extends \Psr\Log\AbstractLogger
{
    
    /**
     * @param       $message
     * @param array $context
     */
    public function event($message, array $context = [])
    {
        $this->log(LogLevel::EVENT, $message, $context);
    }
    
}