<?php

namespace Colibri\Validator\Messages;

use Colibri\Validator\MessageInterface;

/**
 * Class WarningMessage
 * @package Colibri\Validator\Messages
 */
class WarningMessage extends AbstractMessage
{
    
    /**
     * WarningMessage constructor.
     *
     * @param string $message
     */
    public function __construct($message)
    {
        parent::__construct($message, MessageInterface::WARNING_CODE);
    }
    
    /**
     * @return string
     */
    public function toString(): string
    {
        return sprintf('Warning: %s', $this->toString());
    }
    
}