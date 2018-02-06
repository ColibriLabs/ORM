<?php

namespace Colibri\Validator\Messages;

use Colibri\Validator\MessageInterface;
use Colibri\Validator\ValidatorException;

/**
 * Class AbstractMessage
 * @package Colibri\Validator
 */
abstract class AbstractMessage implements MessageInterface
{
  
  /**
   * @var string
   */
  private $message;
  
  /**
   * @var int
   */
  private $code;
  
  /**
   * AbstractMessage constructor.
   * @param string $message
   * @param int $code
   */
  public function __construct($message, $code = MessageInterface::ERROR_CODE)
  {
    $this->message  = $message;
    $this->code     = $code;
  }
  
  /**
   * @return string
   */
  public function getMessage(): string
  {
    return $this->message;
  }
  
  /**
   * @return int
   */
  public function getCode(): integer
  {
    return $this->code;
  }
  
  /**
   * @return \Throwable
   */
  public function getException(): \Throwable
  {
    return new ValidatorException($this->getMessage(), $this->getCode());
  }
  
  /**
   * @return void
   * @throws \Throwable
   */
  public function throwException(): void
  {
    throw $this->getException();
  }
  
  /**
   * @return string
   */
  public function toString(): string
  {
    return sprintf('%s [%d]', $this->getMessage(), $this->getCode());
  }
  
}