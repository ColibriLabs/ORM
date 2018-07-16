<?php

namespace Colibri\Core;

/**
 * Interface ProxyInterface
 * @package Colibri\Core
 */
interface ProxyInterface
{
    
    /**
     * @return mixed
     */
    public function initialize();
    
    /**
     * @return boolean
     */
    public function isInitialized();
    
}