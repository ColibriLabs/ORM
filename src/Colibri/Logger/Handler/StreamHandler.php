<?php

namespace Colibri\Logger\Handler;

use Colibri\Extension\ExtensionException;
use Colibri\Logger\Collection\Collection;
use Colibri\Logger\Handler\Mask\LogLevelMask;

/**
 * Class StreamHandler
 * @package Colibri\Logger\Handler
 */
class StreamHandler extends AbstractHandler {

  /**
   * @var resource
   */
  protected $resource;
  
  /**
   * StreamHandler constructor.
   * @param string|resource $source
   * @param int             $level
   * @throws ExtensionException
   */
  public function __construct($source, $level = LogLevelMask::MASK_ALL)
  {
    parent::__construct($level);
    
    switch (true) {
      case is_resource($source):
        $this->resource = $source;
        break;
      case is_string($source):
        $this->resource = $this->openStream($source);
        break;
      default:
        throw new ExtensionException(sprintf('Source doesn\'t not supported'));
        break;
    }
  }

  /**
   * @param Collection $record
   * @return boolean
   */
  public function handle(Collection $record)
  {
    $stringMessage = $this->formatter->format($record) . PHP_EOL;

    return (boolean) $this->writeStream($stringMessage);
  }
  
  /**
   * @param $message
   * @return bool|int
   */
  private function writeStream($message)
  {
    return fwrite($this->resource, $message);
  }
  
  /**
   * @param $filename
   * @return bool|resource
   * @throws ExtensionException
   */
  private function openStream($filename)
  {
    if (!file_exists($filename)) {
      throw new ExtensionException(sprintf('File path (%s) doesn\'t exist', $filename));
    }
  
    if (!is_readable($filename)) {
      throw new ExtensionException(sprintf('File path (%s) doesn\'t readable', $filename));
    }
    
    return fopen($filename, 'a+');
  }


}
