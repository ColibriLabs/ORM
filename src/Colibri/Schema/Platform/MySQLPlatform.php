<?php

namespace Colibri\Schema\Platform;

use Colibri\Schema\Platform;

/**
 * Class MySQLPlatform
 * @package Colibri\Schema\Platform
 */
class MySQLPlatform extends Platform
{
    
    /**
     * MySQLPlatform constructor.
     */
    public function __construct()
    {
        parent::__construct('mysql');
    }
    
}