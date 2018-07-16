<?php

namespace Colibri\Core;

/**
 * Interface HydratorInterface
 * @package Colibri\Core
 */
interface HydratorInterface
{
    
    /**
     * @param array  $data
     * @param object $object
     *
     * @return mixed
     */
    public function hydrate(array $data, $object);
    
    /**
     * @param object $object
     *
     * @return array
     */
    public function extract($object);
    
}