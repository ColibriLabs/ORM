<?php

namespace Colibri\Generator\Template;

use Colibri\Collection\Collection;

/**
 * Class Template
 * @package Colibri\Generator\Template
 */
class Template implements \ArrayAccess
{
    
    /**
     * @var Collection
     */
    protected $data;
    
    /**
     * @var
     */
    protected $directory;
    
    /**
     * Template constructor.
     *
     * @param $directory
     */
    public function __construct($directory)
    {
        $this->directory = $directory;
        $this->data = new Collection();
    }
    
    /**
     * @param $name
     * @param $value
     *
     * @return $this
     */
    public function set($name, $value)
    {
        $this->data->set($name, $value);
        
        return $this;
    }
    
    /**
     * @param array $variables
     *
     * @return $this
     */
    public function batch(array $variables = [])
    {
        $this->data->batch($variables);
        
        return $this;
    }
    
    /**
     * @param      $name
     * @param null $default
     *
     * @return mixed|null
     */
    public function get($name, $default = null)
    {
        return $this->data->get($name, $default);
    }
    
    /**
     * @param $name
     *
     * @return $this
     */
    public function remove($name)
    {
        $this->data->remove($name);
        
        return $this;
    }
    
    /**
     * @param $template
     *
     * @return string
     */
    public function render($template)
    {
        $template = "{$this->directory}/{$template}";
        
        ob_start();
        ob_implicit_flush();
        
        /** @var string $template */
        if (file_exists($template)) {
            extract($this->data->toArray());
            include $template;
        } else {
            return "/** [$template] */";
        }
        
        return ob_get_clean();
    }
    
    /**
     * @param mixed $offset
     *
     * @return bool
     */
    function offsetExists($offset)
    {
        return $this->data->offsetExists($offset);
    }
    
    /**
     * @param mixed $offset
     *
     * @return mixed|void
     */
    public function offsetGet($offset)
    {
        return $this->data->get($offset);
    }
    
    /**
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value)
    {
        $this->data->set($offset, $value);
    }
    
    /**
     * @param mixed $offset
     */
    public function offsetUnset($offset)
    {
        $this->data->remove($offset);
    }
    
}