<?php

namespace Colibri\Logger\Formatter;

use Colibri\Logger\Collection\Collection;

/**
 * Class LineFormatter
 * @package Colibri\Logger\Formatter
 */
class LineFormatter extends AbstractFormatter
{

  /**
   * LineFormatter constructor.
   * @param null $format
   */
  public function __construct($format = null)
  {
    if (null !== $format) {
      $this->setFormat($format);
    }
  }

  /**
   * @param Collection $record
   * @return string
   */
  public function format(Collection $record)
  {
    return $this->replace($this->getFormat(), $this->prepare($record));
  }

}