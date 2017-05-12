<?php

namespace Colibri\EventDispatcher;

use Colibri\Exception\BadArgumentException;

/**
 * Class Dispatcher
 * @package Colibri\EventDispatcher
 */
class Dispatcher implements DispatcherInterface
{

  /**
   * @var array
   */
  protected $listeners = [];

  /**
   * @var array
   */
  protected $sorted = [];
  
  /**
   * @inheritDoc
   */
  public function dispatch($eventName, EventInterface $event = null)
  {
    if ($this->hasListeners($eventName)) {
      if ($event === null)
        $event = new Event();

      foreach ($this->getListeners($eventName) as $listener) {
        if (is_callable($listener, true)) {
          call_user_func_array($listener, [$event, $eventName, $this]);
          if ($event->isStopped()) {
            break;
          }
        } else {
          throw new EventDispatcherException('Listener is not callable');
        }
      }
    }

    return $event;
  }
  
  /**
   * @inheritDoc
   */
  public function hasListeners($eventName)
  {
    return isset($this->listeners[$eventName]);
  }
  
  /**
   * @inheritDoc
   */
  public function getListeners($eventName)
  {
    $this->sortListeners($eventName);

    return $this->sorted[$eventName];
  }
  
  /**
   * @inheritDoc
   */
  public function sortListeners($eventName)
  {
    if ($this->hasListeners($eventName)) {
      $this->sorted[$eventName] = [];
      $listeners = $this->listeners[$eventName];
      ksort($listeners);
      $this->sorted[$eventName] = call_user_func_array('array_merge', $listeners);
    }

    return $this;
  }
  
  /**
   * @inheritDoc
   */
  public function addListener($eventName, $listener, $position = 0)
  {
    $this->listeners[$eventName][$position][]
      = $listener;
    $this->sorted[$eventName] = [];

    return $this;
  }
  
  /**
   * @inheritDoc
   */
  public function subscribeListener(EventSubscriber $subscriber)
  {
    foreach ($subscriber->getEvents() as $eventName) {
      if (is_callable([$subscriber, $eventName])) {
        $this->addListener($eventName, [$subscriber, $eventName]);
      } else {
        throw new BadArgumentException('Event subscriber should have method witch same event name. Method :method', [
          'method' => $eventName,
        ]);
      }
    }
    
    return $this;
  }
  
  /**
   * @inheritDoc
   */
  public function removeListener($eventName)
  {
    if ($this->hasListeners($eventName))
      unset($this->sorted[$eventName], $this->listeners[$eventName]);
    
    return $this;
  }

}