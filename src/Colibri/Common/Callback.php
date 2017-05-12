<?php

namespace Colibri\Common;

use Colibri\Exception\BadArgumentException;

/**
 * Class Callback
 * @package Colibri\Common
 */
class Callback
{

  /**
   * @var callable
   */
  protected $callback;

  /**
   * Callback constructor.
   * @param $callback
   * @throws BadArgumentException
   */
  public function __construct($callback)
  {
    if (!is_callable($callback, true)) {
      throw new BadArgumentException('Argument for ":class" constructor should be callable', [
        'class' => static::class
      ]);
    }

    $this->callback = $callback;
  }

  /**
   * @param array ...$arguments
   * @return mixed
   */
  public function __invoke(...$arguments)
  {
    return $this->call(...$arguments);
  }

  /**
   * @return callable
   */
  public function getCallback()
  {
    return $this->callback;
  }

  /**
   * @param array ...$parameters
   * @return mixed
   */
  public function call(...$parameters)
  {
    return call_user_func($this->getCallback(), ...$parameters);
  }

}