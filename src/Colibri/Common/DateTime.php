<?php

namespace Colibri\Common;

/**
 * Class DateTime
 *
 * @package Colibri\Common
 */
class DateTime extends \DateTime
{

  /**
   * @var string
   */
  protected $dateTimeFormat = parent::ATOM;

  /**
   * @param mixed $format
   * @return $this
   */
  public function setFormat($format)
  {
    $this->dateTimeFormat = $format;

    return $this;
  }

  /**
   * @return mixed
   */
  public function getFormat()
  {
    return $this->dateTimeFormat;
  }

  /**
   * @return string
   */
  public function __toString()
  {
    return $this->format($this->getFormat());
  }

}