<?php

namespace Colibri\EventDispatcher;

/**
 * Interface EventSubscriber
 * @package Colibri\EventDispatcher
 */
interface EventSubscriber
{
  
  /**
   * @return array
   */
  public function getEvents();
  
}