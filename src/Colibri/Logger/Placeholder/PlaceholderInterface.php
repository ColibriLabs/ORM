<?php

namespace Colibri\Logger\Placeholder;

use Colibri\Logger\Collection\Collection;

/**
 * Interface PlaceholderInterface
 * @package Colibri\Logger\Placeholder
 */
interface PlaceholderInterface
{
  
  /**
   * @param Collection $record
   *
   * @return void
   */
  public function complement(Collection $record);
  
}