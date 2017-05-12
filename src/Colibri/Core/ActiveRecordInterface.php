<?php

namespace Colibri\Core;

/**
 * Interface ActiveRecordInterface
 * @package Colibri\Core
 */
interface ActiveRecordInterface
{

  /**
   * @return integer
   */
  public function save();

  /**
   * @return integer
   */
  public function delete();

}