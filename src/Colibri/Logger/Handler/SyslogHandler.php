<?php

namespace Colibri\Logger\Handler;

use Colibri\Logger\Collection\Collection;
use Colibri\Logger\Handler\Mask\LogLevelMask;

/**
 * Class SyslogHandler
 * @package Colibri\Logger\Handler
 */
class SyslogHandler extends AbstractHandler
{
    
    /**
     * SyslogHandler constructor.
     *
     * @param     $ident
     * @param int $options
     * @param int $facility
     * @param int $level
     */
    public function __construct($ident, $options = LOG_ODELAY, $facility = LOG_USER, $level = LogLevelMask::MASK_ALL)
    {
        parent::__construct($level);
        
        openlog($ident, $options, $facility);
    }
    
    /**
     * @param Collection $record
     *
     * @return void
     */
    public function handle(Collection $record)
    {
        error_log($this->formatter->format($record));
    }
    
}
