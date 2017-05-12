<?php

namespace Colibri\Logger\Handler;

use Colibri\Logger\Collection\ArrayCollection;

/**
 * Class EchoHandler
 * @package Colibri\Logger\Handler
 */
class EchoHandler extends AbstractHandler {

  /**
   * @param ArrayCollection $record
   * @return null
   */
  public function handle(ArrayCollection $record)
  {
    echo $this->getFormatter()->format($record) . PHP_EOL;

    return true;
  }

}