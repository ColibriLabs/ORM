<?php

namespace Colibri\Validator;

use Colibri\Common\StringableInterface;

/**
 * Interface MessageInterface
 * @package Colibri\Validator
 */
interface MessageInterface extends StringableInterface
{
  
  const ERROR_CODE = 10001;
  const WARNING_CODE = 10002;
  const NOTICE_CODE = 10003;
  
  /**
   * @return string
   */
  public function getMessage(): string ;
  
  /**
   * @return int
   */
  public function getCode(): integer;
  
  /**
   * @return \Throwable
   */
  public function getException(): \Throwable;
  
  /**
   * @return void
   * @throws \Throwable
   */
  public function throwException(): void;
  
}