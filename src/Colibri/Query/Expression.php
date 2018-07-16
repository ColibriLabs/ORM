<?php

namespace Colibri\Query;

use Colibri\Exception\NullPointerException;

/**
 * Class Expression
 * @package Colibri\Query
 */
abstract class Expression implements SqlableInterface
{
    
    /**
     * @var Builder
     */
    protected $builder = null;
    
    /**
     * @inheritdoc
     */
    function __debugInfo()
    {
        return [
            'expression_class' => static::class,
            'hash_code'        => $this->hashCode(),
            'has_builder'      => (null !== $this->builder),
        ];
    }
    
    /**
     * @return string
     */
    public function hashCode()
    {
        return sprintf('%s@%s', static::class, sha1(spl_object_hash($this)));
    }
    
    /**
     * @return string
     */
    abstract public function __toString();
    
    /**
     * @param $identifier
     *
     * @return string
     */
    protected function sanitize($identifier)
    {
        return $this->getBuilder()->quoteIdentifier($identifier);
    }
    
    /**
     * @return Builder
     * @throws NullPointerException
     */
    public function getBuilder()
    {
        if (null === $this->builder) {
            throw new NullPointerException('Expression ":class" should have injected builder object', ['class' => static::class,]);
        }
        
        return $this->builder;
    }
    
    /**
     * @param Builder $builder
     *
     * @return $this
     */
    public function setBuilder(Builder $builder)
    {
        $this->builder = $builder;
        
        return $this;
    }
    
    /**
     * @param     $value
     * @param int $type
     *
     * @return string
     */
    protected function escape($value, $type = \PDO::PARAM_STR)
    {
        return $this->getBuilder()->getConnection()->escape($value, $type);
    }
    
}