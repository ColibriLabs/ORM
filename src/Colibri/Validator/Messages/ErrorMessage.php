<?php

namespace Colibri\Validator\Messages;

use Colibri\Validator\MessageInterface;

/**
 * Class ErrorMessage
 * @package Colibri\Validator\Messages
 */
class ErrorMessage extends AbstractMessage
{
    
    /**
     * ErrorMessage constructor.
     *
     * @param string $message
     */
    public function __construct($message)
    {
        parent::__construct($message, MessageInterface::ERROR_CODE);
    }
    
    /**
     * @return string
     */
    public function toString(): string
    {
        return sprintf('Error: %s', $this->toString());
    }
    
}