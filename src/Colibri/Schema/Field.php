<?php

namespace Colibri\Schema;

use Colibri\Common\ArrayableInterface;
use Colibri\Common\Inflector;
use Colibri\Schema\Types\Type;

/**
 * Class Field
 * @package Colibri\Schema
 */
class Field implements ArrayableInterface
{
    
    /**
     * @var
     */
    protected $column;
    
    /**
     * @var
     */
    protected $name;
    
    /**
     * @var Type
     */
    protected $type;
    
    /**
     * @var
     */
    protected $default;
    
    /**
     * @var bool
     */
    protected $unsigned = false;
    
    /**
     * @var bool
     */
    protected $nullable = false;
    
    /**
     * @var bool
     */
    protected $autoIncrement = false;
    
    /**
     * @var bool
     */
    protected $primaryKey = false;
    
    /**
     * @var bool
     */
    protected $identity = false;
    
    /**
     * Field constructor.
     *
     * @param string $column
     */
    public function __construct($column)
    {
        $this->setColumn($column);
    }
    
    /**
     * @param array $parameters
     *
     * @return static
     */
    public static function __set_state(array $parameters = [])
    {
        $instance = new static(null);
        $reflection = new \ReflectionClass(static::class);
        
        foreach ($parameters as $name => $value) {
            if ($reflection->hasProperty($name) && $reflection->getProperty($name)->isProtected()) {
                $property = $reflection->getProperty($name);
                $property->setAccessible(true);
                $property->setValue($instance, $value);
            }
        }
        
        return $instance;
    }
    
    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->getType()->toPlatformValue($this->getDefault());
    }
    
    /**
     * @return Type
     */
    public function getType()
    {
        return $this->type;
    }
    
    /**
     * @param Type $type
     *
     * @return $this
     */
    public function setType(Type $type)
    {
        $this->type = $type;
        
        return $this;
    }
    
    /**
     * @return mixed
     */
    public function getDefault()
    {
        return $this->default;
    }
    
    /**
     * @param mixed $default
     *
     * @return $this
     */
    public function setDefault($default)
    {
        $this->default = $default;
        
        return $this;
    }
    
    /**
     * @return string
     */
    public function getConstantifyName()
    {
        return Inflector::constantify($this->getName());
    }
    
    /**
     * @return mixed
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
    
    /**
     * @return string
     */
    public function getCamelizeName()
    {
        return Inflector::camelize($this->getName());
    }
    
    /**
     * @return string
     */
    public function getClassifyName()
    {
        return Inflector::classify($this->getName());
    }
    
    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'column'        => $this->getColumn(),
            'name'          => $this->getName(),
            'default'       => $this->getDefault(),
            'typeName'      => $this->getType()->getName(),
            'typePhpName'   => $this->getType()->getPhpName(),
            'length'        => $this->getType()->getLength(),
            'precision'     => $this->getType()->getPrecision(),
            'unsigned'      => $this->isUnsigned(),
            'nullable'      => $this->isNullable(),
            'autoIncrement' => $this->isAutoIncrement(),
            'primaryKey'    => $this->isPrimaryKey(),
            'identity'      => $this->isIdentity(),
        ];
    }
    
    /**
     * @return mixed
     */
    public function getColumn()
    {
        return $this->column;
    }
    
    /**
     * @param mixed $column
     *
     * @return $this
     */
    public function setColumn($column)
    {
        $this->column = $column;
        
        return $this;
    }
    
    /**
     * @return boolean
     */
    public function isUnsigned()
    {
        return $this->unsigned;
    }
    
    /**
     * @param boolean $unsigned
     *
     * @return $this
     */
    public function setUnsigned($unsigned)
    {
        $this->unsigned = $unsigned;
        
        return $this;
    }
    
    /**
     * @return boolean
     */
    public function isNullable()
    {
        return $this->nullable;
    }
    
    /**
     * @param boolean $nullable
     *
     * @return $this
     */
    public function setNullable($nullable)
    {
        $this->nullable = $nullable;
        
        return $this;
    }
    
    /**
     * @return boolean
     */
    public function isAutoIncrement()
    {
        return $this->autoIncrement;
    }
    
    /**
     * @param boolean $autoIncrement
     *
     * @return $this
     */
    public function setAutoIncrement($autoIncrement)
    {
        $this->autoIncrement = $autoIncrement;
        
        return $this;
    }
    
    /**
     * @return boolean
     */
    public function isPrimaryKey()
    {
        return $this->primaryKey;
    }
    
    /**
     * @param boolean $primaryKey
     *
     * @return $this
     */
    public function setPrimaryKey($primaryKey)
    {
        $this->primaryKey = $primaryKey;
        
        return $this;
    }
    
    /**
     * @return boolean
     */
    public function isIdentity()
    {
        return $this->identity;
    }
    
    /**
     * @param boolean $identity
     */
    public function setIdentity($identity)
    {
        $this->identity = $identity;
    }
}