<?php

namespace Colibri\Logger\Placeholder;

use Colibri\Logger\Collection\Collection;

/**
 * Class ServerVariablesPlaceholder
 * @package Colibri\Logger\Placeholder
 */
class ServerVariablesPlaceholder extends AbstractPlaceholder
{
    
    /**
     * @var array
     */
    private $serverVariables = [
        'ip' => 'REMOTE_ADDR',
        'port' => 'REMOTE_PORT',
        'host' => 'HTTP_HOST',
        'httpMethod' => 'REQUEST_METHOD',
        'uri' => 'REQUEST_URI',
        'userAgent' => 'HTTP_USER_AGENT',
    ];
    
    /**
     * @param Collection $record
     */
    public function complement(Collection $record)
    {
        foreach ($this->serverVariables as $name => $serverKey) {
            $record->set($name, $_SERVER[$serverKey] ?? 'NULL');
        }
    }
    
}