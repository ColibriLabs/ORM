<?php

namespace Colibri\EventDispatcher;

/**
 * Interface EventInterface
 * @package Colibri\EventDispatcher
 */
interface EventInterface
{

  /**
   * @return mixed
   */
  public function isStopped();

  /**
   * @return mixed
   */
  public function stop();

}