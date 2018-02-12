<?php

namespace Colibri\Validator;

/**
 * Interface ValidatorRuleInterface
 * @package Colibri\Validator
 */
interface ValidatorRuleInterface extends ValidableInterface
{
  
  /**
   * @return MessageInterface
   */
  public function getMessage(): MessageInterface;
  
  /**
   * @param MessageInterface $message
   * @return ValidatorRuleInterface
   */
  public function setMessage(MessageInterface $message): ValidatorRuleInterface;
  
  /**
   * @return bool
   */
  public function isInterruptible(): boolean;
  
}