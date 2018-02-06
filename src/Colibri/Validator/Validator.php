<?php

namespace Colibri\Validator;

use Colibri\Collection\Collection;
use Colibri\Collection\CollectionInterface;
use Colibri\Common\StringableInterface;

/**
 * Class Validator
 * @package Colibri\Validator
 */
class Validator implements ValidatorInterface, StringableInterface
{
  
  /**
   * @var Collection|ValidatorRuleInterface[]
   */
  protected $rules;
  
  /**
   * @var Collection|MessageInterface[]
   */
  protected $messages;
  
  /**
   * Validator constructor.
   */
  public function __construct()
  {
    $this->rules = new Collection([], ValidatorRuleInterface::class);
    $this->messages = new Collection([], MessageInterface::class);
  }
  
  /**
   * @return bool
   */
  public function validate(): boolean
  {
    $isValidate = true;
    
    foreach ($this->rules as $rule) {
      
      // validate each rule and save $isValidate state
      if (false === ($isValidate = ($isValidate && $rule->validate()))) {
        
        // append each failed message
        $this->messages->append($rule->getMessage());
        
        // if rule is as interruptible then break iteration
        if ($rule->isInterruptible()) break;
      }
    }
    
    return $isValidate;
  }
  
  /**
   * @param ValidatorRuleInterface $rule
   * @return ValidableInterface
   */
  public function append(ValidatorRuleInterface $rule): ValidableInterface
  {
    $this->rules->append($rule);
    
    return $this;
  }
  
  /**
   * @param ValidatorRuleInterface $rule
   * @return ValidableInterface
   */
  public function prepend(ValidatorRuleInterface $rule): ValidableInterface
  {
    $this->rules->prepend($rule);
    
    return $this;
  }
  
  /**
   * @return CollectionInterface
   */
  public function getRules(): CollectionInterface
  {
    return $this->rules;
  }
  
  /**
   * @return CollectionInterface
   */
  public function getMessages(): CollectionInterface
  {
    return $this->messages;
  }
  
  /**
   * @return bool
   */
  public function isFailed(): boolean
  {
    return $this->messages->count() > 0;
  }
  
  /**
   * @return string
   */
  public function toString(): string
  {
    return implode($this->messages->toArray());
  }
  
  /**
   * @return string
   */
  public function __toString()
  {
    return $this->toString();
  }
  
}