<?php

namespace Colibri\Logger\Formatter;

use Colibri\Logger\Collection\ArrayCollection;

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
   * @param ArrayCollection $record
   * @return string
   */
  public function format(ArrayCollection $record)
  {
    return $this->replace($this->getFormat(), $this->prepare($record));
  }

}