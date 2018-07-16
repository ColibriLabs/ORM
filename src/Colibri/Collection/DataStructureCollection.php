<?php

namespace Colibri\Collection;

use Colibri\Common\Inflector;
use Colibri\Exception\NotSupportedException;

/**
 * Class DataStructureCollection
 * @package Colibri\Collection
 */
class DataStructureCollection extends Collection
{
    
    /**
     * @param $name
     *
     * @return mixed|null
     */
    public function __get($name)
    {
        return $this->get($this->fromCamelized($name));
    }
    
    /**
     * @param $name
     * @param $value
     *
     * @return $this
     */
    public function __set($name, $value)
    {
        return $this->set($this->fromCamelized($name), $value);
    }
    
    /**
     * @param $name
     *
     * @return string
     */
    public function fromCamelized($name)
    {
        return Inflector::underscore($name);
    }
    
    /**
     * @param $name
     * @param $value
     *
     * @return mixed|$this
     * @throws NotSupportedException
     */
    public function __call($name, $value)
    {
        $method = substr($name, 0, 3);
        $name = $this->fromClassify(substr($name, 3));
        
        if (in_array($method, ['get', 'set'])) {
            return $this->$method(...[$name, $value]);
        }
        
        throw new NotSupportedException('Not supported magic method calling');
    }
    
    /**
     * @param $name
     *
     * @return string
     */
    public function fromClassify($name)
    {
        return Inflector::underscore($name);
    }
    
    /**
     * @param $name
     *
     * @return string
     */
    public function fromUnderscored($name)
    {
        return Inflector::camelize($name);
    }
    
}