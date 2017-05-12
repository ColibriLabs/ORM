<?php

namespace Colibri\Logger\Formatter;

use Colibri\Logger\Collection\Collection;

/**
 * Interface FormatterInterface
 * @package Colibri\Logger\Formatter
 */
interface FormatterInterface
{

  const PLACEHOLDER_MASK_DOUBLE_DOT = ':%s';

  const PLACEHOLDER_MASK_BRACKETS = '{%s}';

  /**
   * @param Collection $record
   * @return mixed
   */
  public function format(Collection $record);

}