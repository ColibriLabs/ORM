<?php

namespace Colibri\Logger;

use Colibri\Logger\Collection\Collection;
use Colibri\Logger\Handler\HandlerInterface;
use Colibri\Logger\Handler\Mask\LogLevelMask;
use Psr\Log\AbstractLogger;

class Log extends AbstractLogger
{

  /**
   * @var Collection
   */
  protected $handlers = null;

  /**
   * Log constructor.
   */
  public function __construct()
  {
    $this->handlers = new Collection();
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
   * @return Collection
   */
  protected function prepareRecord($level, $message, array $context = [])
  {
    $message = new Collection([
      'content' => $message,
      'context' => $context,
    ]);

    $record = new Collection([
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