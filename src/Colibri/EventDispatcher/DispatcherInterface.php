<?php

namespace Colibri\EventDispatcher;

/**
 * Interface DispatcherInterface
 *
 * @package Colibri\EventDispatcher
 */
interface DispatcherInterface
{

  /**
   * @param $eventName
   * @param EventInterface|null $event
   * @return EventInterface
   */
  public function dispatch($eventName, EventInterface $event = null);

  /**
   * @param $eventName
   * @param $listener
   * @return $this
   */
  public function addListener($eventName, $listener);
  
  /**
   * @param EventSubscriber $subscriber
   * @return $this
   */
  public function subscribeListener(EventSubscriber $subscriber);
  
  /**
   * @param $eventName
   * @return $this
   */
  public function removeListener($eventName);

  /**
   * @param $eventName
   * @return boolean
   */
  public function hasListeners($eventName);

  /**
   * @param $eventName
   * @return array
   */
  public function getListeners($eventName);

  /**
   * @param $eventName
   * @return $this
   */
  public function sortListeners($eventName);

}