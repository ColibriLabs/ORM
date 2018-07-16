<?php

namespace Colibri\Extension;

use Colibri\Parameters\ParametersCollection;

/**
 * Interface ExtensionInterface
 * @package Colibri\Extension
 */
interface ExtensionInterface
{
    
    /**
     * @param ParametersCollection $collection
     *
     * @return mixed
     */
    public function setConfiguration(ParametersCollection $collection);
    
    /**
     * @return ParametersCollection
     */
    public function getConfiguration();
    
    /**
     * @return string
     */
    public function getNameNS();
    
}