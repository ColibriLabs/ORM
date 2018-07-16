<?php

namespace Colibri\Validator\Messages;

use Colibri\Validator\MessageInterface;

/**
 * Class NoticeMessage
 * @package Colibri\Validator\Messages
 */
class NoticeMessage extends AbstractMessage
{
    
    /**
     * NoticeMessage constructor.
     *
     * @param string $message
     */
    public function __construct($message)
    {
        parent::__construct($message, MessageInterface::NOTICE_CODE);
    }
    
    /**
     * @return string
     */
    public function toString(): string
    {
        return sprintf('Notice: %s', $this->toString());
    }
    
}