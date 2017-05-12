<?php

namespace Colibri\EventDispatcher;

/**
 * Class Event
 * @package Colibri\EventDispatcher
 */
class Event implements EventInterface
{

  /**
   * @var bool
   */
  protected $stopped = false;

  /**
   * @return bool
   */
  public function isStopped()
  {
    return $this->stopped;
  }

  /**
   * @return void
   */
  public function stop()
  {
    $this->stopped = true;
  }

}