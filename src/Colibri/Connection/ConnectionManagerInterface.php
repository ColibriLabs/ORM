<?php

namespace Colibri\Connection;

use Colibri\Exception\BadArgumentException;

/**
 * Interface ConnectionManagerInterface
 * @package Colibri\Connection
 */
interface ConnectionManagerInterface
{

  /**
   * @param $name
   * @return ConnectionInterface
   * @throws BadArgumentException
   */
  public function getConnection($name);

}