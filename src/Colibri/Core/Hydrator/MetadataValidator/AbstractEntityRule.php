<?php

namespace Colibri\Core\Hydrator\MetadataValidator;

use Colibri\Validator\MessageInterface;
use Colibri\Validator\Messages\WarningMessage;
use Colibri\Validator\Rules\AbstractRule;

/**
 * Class AbstractEntityRule
 * @package Colibri\Core\Hydrator\MetadataValidator
 */
abstract class AbstractEntityRule extends AbstractRule
{
    
    /**
     * @return bool
     */
    public function validate(): boolean
    {
        return false;
    }
    
    /**
     * @return MessageInterface
     */
    protected function setupDefaultMessage(): MessageInterface
    {
        return new WarningMessage(sprintf('Validator rule [%s] was failure when validation was executed', static::class));
    }
    
}