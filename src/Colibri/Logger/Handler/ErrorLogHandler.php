<?php

namespace Colibri\Logger\Handler;

use Colibri\Logger\Collection\ArrayCollection;

/**
 * Class ErrorLogHandler
 * @package Colibri\Logger\Handler
 */
class ErrorLogHandler extends AbstractHandler
{
  
  /**
   * @param ArrayCollection $record
   * @return void
   */
  public function handle(ArrayCollection $record)
  {
    error_log($this->formatter->format($record));
  }
  
}