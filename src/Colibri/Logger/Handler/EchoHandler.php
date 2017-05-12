<?php

namespace Colibri\Logger\Handler;

use Colibri\Logger\Collection\Collection;

/**
 * Class EchoHandler
 * @package Colibri\Logger\Handler
 */
class EchoHandler extends AbstractHandler {

  /**
   * @param Collection $record
   * @return null
   */
  public function handle(Collection $record)
  {
    echo $this->getFormatter()->format($record) . PHP_EOL;

    return true;
  }

}