<?php

namespace Colibri\Logger\Placeholder;

use Colibri\Logger\Collection\Collection;

/**
 * Class SystemIdsPlaceholder
 * @package Colibri\Logger\Placeholder
 */
class SystemIdsPlaceholder extends AbstractPlaceholder
{
    
    /**
     * @param Collection $record
     */
    public function complement(Collection $record)
    {
        $record->batch([
            'pid' => getmypid(),
            'uid' => getmyuid(),
            'gid' => getmygid(),
        ]);
    }
    
}