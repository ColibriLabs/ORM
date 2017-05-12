<?php

namespace Colibri\Logger;

use Colibri\Logger\Collection\ArrayCollection;
use Colibri\Logger\Handler\HandlerInterface;
use Colibri\Logger\Handler\Mask\LogLevelMask;
use Psr\Log\AbstractLogger;

class Log extends AbstractLogger
{

  /**
   * @var ArrayCollection
   */
  protected $handlers = null;

  /**
   * Log constructor.
   */
  public function __construct()
  {
    $this->handlers = new ArrayCollection();
  }

  /**
   * Logs with an arbitrary level.
   *
   * @param mixed $level
   * @param string $message
   * @param array $context
   *
   * @return bool
   */
  public function log($level, $message, array $context = [])
  {
    $record = $this->prepareRecord($level, $message, $context);

    $iterator = $this->handlers->getIterator();

    while ($iterator->valid()) {
      /** @var HandlerInterface $handler */
      $handler = $iterator->current();

      if ($handler->levelAllow($level)) {
        $handler->handle($record);
      }

      $iterator->next();
    }

    return true;
  }

  /**
   * @param $name
   * @param HandlerInterface $handler
   * @return $this
   */
  public function pushHandler($name, HandlerInterface $handler)
  {
    $this->handlers->set($name, $handler);

    return $this;
  }

  /**
   * @param $level
   * @param $message
   * @param array $context
   * @return ArrayCollection
   */
  protected function prepareRecord($level, $message, array $context = [])
  {
    $message = new ArrayCollection([
      'content' => $message,
      'context' => $context,
    ]);

    $record = new ArrayCollection([
      'level' => strtoupper($level),
      'level_bitmask' => new LogLevelMask($level),
      'datetime' => new DateTime(),
      'message' => $message,
    ]);

    $serverVariables = [
      'ip' => 'REMOTE_ADDR',
      'port' => 'REMOTE_PORT',
      'host' => 'HTTP_HOST',
      'http_method' => 'REQUEST_METHOD',
      'uri' => 'REQUEST_URI'
    ];

    foreach ($serverVariables as $name => $serverKey) {
      if (isset($_SERVER[$serverKey])) {
        $record->set($name, $_SERVER[$serverKey]);
      }
    }

    return $record;
  }

}