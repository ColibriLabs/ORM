<?php

namespace Colibri\Validator\Rules;

use Colibri\Validator\MessageInterface;
use Colibri\Validator\ValidatorRuleInterface;

/**
 * Class AbstractRule
 * @package Colibri\Validator\Rules
 */
abstract class AbstractRule implements ValidatorRuleInterface
{
  
  /**
   * @var MessageInterface
   */
  private $message;
  
  /**
   * AbstractRule constructor.
   * @param MessageInterface|null $message
   */
  public function __construct(MessageInterface $message = null)
  {
    $this->message = $message;
  }
  
  /**
   * @return MessageInterface
   */
  public function getMessage(): MessageInterface
  {
    return $this->message;
  }
  
  /**
   * @return bool
   */
  public function isInterruptible(): boolean
  {
    return false;
  }
  
}