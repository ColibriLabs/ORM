<?php

namespace Colibri\Query\Expr;

use Colibri\Query\Expression;

/**
 * Class Table
 * @package Colibri\Query\Expr
 */
class Table extends Expression
{
    
    /**
     * @var string
     */
    protected $database = null;
    
    /**
     * @var string
     */
    protected $name = null;
    
    /**
     * @var string
     */
    protected $alias = null;
    
    /**
     * Table constructor.
     *
     * @param string $table
     */
    public function __construct($table)
    {
        $this->parse($table);
    }
    
    /**
     * @param $table
     */
    protected function parse($table)
    {
        list($this->database, $this->name) = array_pad(explode('.', $table), -2, null);
    }
    
    /**
     * @return string
     */
    public function getAlias()
    {
        return $this->alias;
    }
    
    /**
     * @param string $alias
     *
     * @return $this
     */
    public function setAlias($alias)
    {
        $this->alias = $alias;
        
        return $this;
    }
    
    /**
     * The __toString method allows a class to decide how it will react when it is converted to a string.
     *
     * @return string
     * @link http://php.net/manual/en/language.oop5.magic.php#language.oop5.magic.tostring
     */
    function __toString()
    {
        return $this->toSQL();
    }
    
    /**
     * @return string
     */
    public function toSQL()
    {
        return $this->sanitize($this->format());
    }
    
    /**
     * @return string
     */
    public function format()
    {
        $table = implode('.', array_filter([$this->getDatabase(), $this->getName()]));
        
        return $table;
    }
    
    /**
     * @return string
     */
    public function getDatabase()
    {
        return $this->database;
    }
    
    /**
     * @param mixed $database
     *
     * @return $this
     */
    public function setDatabase($database)
    {
        $this->database = $database;
        
        return $this;
    }
    
    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    
    /**
     * @param mixed $name
     *
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;
        
        return $this;
    }
    
}