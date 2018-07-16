<?php

namespace Colibri\Logger\Handler\Mask;

/**
 * Interface MaskInterface
 * @package Colibri\Logger\Handler\Mask
 */
interface MaskInterface
{
    
    /**
     * @param integer $mask
     *
     * @throws \InvalidArgumentException
     * @return MaskInterface
     */
    public function set($mask);
    
    /**
     * @param $mask
     *
     * @return MaskInterface
     */
    public function add($mask);
    
    /**
     * @return integer
     */
    public function get();
    
    /**
     * @param $mask
     *
     * @return MaskInterface
     */
    public function remove($mask);
    
    /**
     * @return MaskInterface
     */
    public function reset();
    
    /**
     * @param string|integer $mask
     *
     * @throws \InvalidArgumentException
     * @return integer
     */
    public function resolve($mask);
    
    /**
     * @param $mask
     *
     * @return boolean
     */
    public function has($mask);
    
}