<?php

namespace Colibri\Logger\Handler\Mask;

/**
 * Class LogLevelMask
 * @package Colibri\Logger\Handler\Mask
 */
class LogLevelMask extends AbstractMask
{

  const MASK_EMERGENCY = 1;
  const MASK_ALERT = 2;
  const MASK_CRITICAL = 4;
  const MASK_ERROR = 8;
  const MASK_WARNING = 16;
  const MASK_NOTICE = 32;
  const MASK_INFO = 64;
  const MASK_DEBUG = 128;
  const MASK_EVENT = 256;

  const MASK_ALL = (self::MASK_EVENT * 2) - 1;

}