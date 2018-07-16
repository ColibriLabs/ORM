<?php

namespace Colibri\Validator;

use Colibri\Collection\CollectionInterface;

/**
 * Interface ValidatorInterface
 * @package Colibri\Validator
 */
interface ValidatorInterface extends ValidableInterface
{
    
    /**
     * @param ValidatorRuleInterface $rule
     *
     * @return ValidableInterface
     */
    public function append(ValidatorRuleInterface $rule): ValidableInterface;
    
    /**
     * @param ValidatorRuleInterface $rule
     *
     * @return ValidableInterface
     */
    public function prepend(ValidatorRuleInterface $rule): ValidableInterface;
    
    /**
     * @return CollectionInterface
     */
    public function getRules(): CollectionInterface;
    
    /**
     * @return CollectionInterface
     */
    public function getMessages(): CollectionInterface;
    
    /**
     * @return bool
     */
    public function isFailed(): boolean;
    
}