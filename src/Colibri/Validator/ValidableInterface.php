<?php

namespace Colibri\Validator;

/**
 * Interface ValidableInterface
 * @package Colibri\Validator
 */
interface ValidableInterface
{
  
  /**
   * @return bool
   */
  public function validate(): boolean;
  
}