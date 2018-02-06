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
   * @return bool
   */
  public function isInterruptible(): boolean;
  
}