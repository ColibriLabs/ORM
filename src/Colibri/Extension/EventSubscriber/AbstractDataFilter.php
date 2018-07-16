<?php

namespace Colibri\Extension\EventSubscriber;

use Colibri\Core\ORMEvents;
use Colibri\Extension\AbstractExtension;

/**
 * Class AbstractDataFilter
 * @package Colibri\Extension\EventSubscriber
 */
abstract class AbstractDataFilter extends AbstractExtension
{
    
    /**
     * @return array
     */
    public function getEvents()
    {
        return [ORMEvents::beforePersist];
    }
    
}