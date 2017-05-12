<?php

namespace Colibri\Logger\Formatter;

use Colibri\Logger\Collection\ArrayCollection;

/**
 * Interface FormatterInterface
 * @package Colibri\Logger\Formatter
 */
interface FormatterInterface
{

  const PLACEHOLDER_MASK_DOUBLE_DOT = ':%s';

  const PLACEHOLDER_MASK_BRACKETS = '{%s}';

  /**
   * @param ArrayCollection $record
   * @return mixed
   */
  public function format(ArrayCollection $record);

}