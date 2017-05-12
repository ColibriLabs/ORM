<?php

namespace Colibri\Logger\Handler;

use Colibri\Logger\Collection\Collection;

/**
 * Class ErrorLogHandler
 * @package Colibri\Logger\Handler
 */
class ErrorLogHandler extends AbstractHandler
{
  
  /**
   * @param Collection $record
   * @return void
   */
  public function handle(Collection $record)
  {
    error_log($this->formatter->format($record));
  }
  
}