<?php

namespace Colibri\Logger;

use Colibri\Logger\Collection\Collection;
use Colibri\Logger\Handler\HandlerInterface;
use Colibri\Logger\Handler\Mask\LogLevelMask;
use Psr\Log\AbstractLogger;
use Psr\Log\LoggerInterface;

/**
 * Class Log
 * @package Colibri\Logger
 */
class Log extends AbstractLogger
{

  /**
   * @var Collection
   */
  protected $handlers = null;
  
  /**
   * @var string
   */
  protected $name;
  
  /**
   * @var string
   */
  protected $datetimeFormat = DATE_ATOM;
  
  /**
   * Log constructor.
   * @param string|null $name
   */
  public function __construct($name = null)
  {
    $this->handlers = new Collection();
    $this->name = $name;
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
   * @return LoggerInterface
   */
  public function pushHandler($name, HandlerInterface $handler): LoggerInterface
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
  protected function prepareRecord(string $level, string $message = null, array $context = []): Collection
  {
    $message = new Collection([
      'content' => $message,
      'context' => $context,
    ]);
    
    $datetime = new DateTime();
    $datetime->setFormat($this->getDatetimeFormat());

    $record = new Collection([
      'name' => $this->name,
      'level' => strtoupper($level),
      'levelBitmask' => new LogLevelMask($level),
      'datetime' => $datetime,
      'message' => $message,
    ]);
  
    $record->batch([
      'pid' => getmypid(),
      'uid' => getmyuid(),
      'gid' => getmygid(),
    ]);

    $serverVariables = [
      'ip' => 'REMOTE_ADDR',
      'port' => 'REMOTE_PORT',
      'host' => 'HTTP_HOST',
      'httpMethod' => 'REQUEST_METHOD',
      'uri' => 'REQUEST_URI',
      'userAgent' => 'HTTP_USER_AGENT',
    ];

    foreach ($serverVariables as $name => $serverKey) {
      if (isset($_SERVER[$serverKey])) {
        $record->set($name, $_SERVER[$serverKey]);
      }
    }

    return $record;
  }
  
  /**
   * @return string
   */
  public function getDatetimeFormat(): string
  {
    return $this->datetimeFormat;
  }
  
  /**
   * @param string $datetimeFormat
   */
  public function setDatetimeFormat(string $datetimeFormat)
  {
    $this->datetimeFormat = $datetimeFormat;
  }

}
