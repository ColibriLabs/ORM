<?php

namespace Colibri\Logger\Handler;

use Colibri\Logger\Collection\Collection;
use Colibri\Logger\Handler\Mask\LogLevelMask;

/**
 * Class StreamHandler
 * @package Colibri\Logger\Handler
 */
class StreamHandler extends AbstractHandler {

  /**
   * @var null|string
   */
  protected $filepath = null;

  /**
   * StreamHandler constructor.
   * @param $filepath
   * @param int $level
   */
  public function __construct($filepath, $level = LogLevelMask::MASK_ALL)
  {
    parent::__construct($level);
    
    if (!file_exists($filepath)) {
      touch($filepath);
    }
    
    $this->filepath = realpath($filepath);
  }

  /**
   * @param Collection $record
   * @return null
   */
  public function handle(Collection $record)
  {
    file_put_contents($this->filepath, $this->formatter->format($record) . PHP_EOL, FILE_APPEND);

    return true;
  }


}
