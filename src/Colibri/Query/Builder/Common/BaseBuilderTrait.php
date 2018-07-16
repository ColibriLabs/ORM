<?php

namespace Colibri\Query\Builder\Common;

use Colibri\Connection\ConnectionInterface;
use Colibri\Query\BuilderInterface;
use Colibri\Query\Expr;
use Colibri\Query\Expression;

/**
 * Trait BaseBuilderTrait
 * @package Colibri\Query\Builder\Common
 */
trait BaseBuilderTrait
{
    
    /**
     * @inheritDoc
     */
    public function table($table)
    {
        $this->getBuilderObject()->table($table);
        
        return $this;
    }
    
    /**
     * @inheritDoc
     */
    public function cleanup()
    {
        $this->getBuilderObject()->cleanup();
        
        return $this;
    }
    
    /**
     * @inheritDoc
     */
    public function isReplaceAliases()
    {
        return $this->getBuilderObject()->isReplaceAliases();
    }
    
    /**
     * @inheritDoc
     */
    public function setReplaceAliases($replaceAliases)
    {
        $this->getBuilderObject()->setReplaceAliases($replaceAliases);
        
        return $this;
    }
    
    /**
     * @inheritDoc
     */
    public function isParameterized()
    {
        return $this->getBuilderObject()->isParameterized();
    }
    
    /**
     * @inheritDoc
     */
    public function setParameterized($parameterized)
    {
        $this->getBuilderObject()->setParameterized($parameterized);
        
        return $this;
    }
    
    /**
     * @inheritDoc
     */
    public function stringifyExpression(Expression $expression)
    {
        return $this->getBuilderObject()->stringifyExpression($expression);
    }
    
    /**
     * @inheritDoc
     */
    public function normalizeExpression(Expression $expression)
    {
        return $this->getBuilderObject()->normalizeExpression($expression);
    }
    
    /**
     * @inheritDoc
     */
    public function postProcessExpression(Expression $expression)
    {
        return $this->getBuilderObject()->postProcessExpression($expression);
    }
    
    /**
     * @inheritDoc
     */
    public function preProcessExpression(Expression $expression)
    {
        return $this->getBuilderObject()->preProcessExpression($expression);
    }
    
    /**
     * @inheritDoc
     */
    public function completeExpression(Expression $expression, $alias = null)
    {
        return $this->getBuilderObject()->completeExpression($expression, $alias);
    }
    
    /**
     * @inheritDoc
     */
    public function createTable($definition)
    {
        return $this->getBuilderObject()->createTable($definition);
    }
    
    /**
     * @inheritDoc
     */
    public function createColumn($definition)
    {
        return $this->getBuilderObject()->createColumn($definition);
    }
    
    /**
     * @inheritDoc
     */
    public function hasColumnAlias($alias)
    {
        return $this->getBuilderObject()->hasColumnAlias($alias);
    }
    
    /**
     * @inheritDoc
     */
    public function hasTableAlias($alias)
    {
        return $this->getBuilderObject()->hasTableAlias($alias);
    }
    
    /**
     * @inheritDoc
     */
    public function hasFunctionAlias($alias)
    {
        return $this->getBuilderObject()->hasFunctionAlias($alias);
    }
    
    /**
     * @inheritDoc
     */
    public function hasSubqueryAlias($alias)
    {
        return $this->getBuilderObject()->hasSubqueryAlias($alias);
    }
    
    /**
     * @inheritDoc
     */
    public function getColumnByAlias($alias)
    {
        return $this->getBuilderObject()->getColumnByAlias($alias);
    }
    
    /**
     * @inheritDoc
     */
    public function getTableByAlias($alias)
    {
        return $this->getBuilderObject()->getTableByAlias($alias);
    }
    
    /**
     * @inheritDoc
     */
    public function getFunctionByAlias($alias)
    {
        return $this->getBuilderObject()->getFunctionByAlias($alias);
    }
    
    /**
     * @inheritDoc
     */
    public function getSubqueryByAlias($alias)
    {
        return $this->getBuilderObject()->getSubqueryByAlias($alias);
    }
    
    /**
     * @inheritDoc
     */
    public function setColumnAlias(Expr\Column $column, $alias)
    {
        $this->getBuilderObject()->setColumnAlias($column, $alias);
        
        return $this;
    }
    
    /**
     * @inheritDoc
     */
    public function setTableAlias(Expr\Table $table, $alias)
    {
        $this->getBuilderObject()->setTableAlias($table, $alias);
        
        return $this;
    }
    
    /**
     * @inheritDoc
     */
    public function setFunctionAlias(Expr\Func $function, $alias)
    {
        $this->getBuilderObject()->setFunctionAlias($function, $alias);
        
        return $this;
    }
    
    /**
     * @inheritDoc
     */
    public function setAlias(Expression $expression, $alias)
    {
        $this->getBuilderObject()->setAlias($expression, $alias);
        
        return $this;
    }
    
    /**
     * @inheritDoc
     */
    public function setExpression(Expression $expression)
    {
        $this->getBuilderObject()->setExpression($expression);
        
        return $this;
    }
    
    /**
     * @inheritDoc
     */
    public function hasExpression(Expression $expression)
    {
        return $this->getBuilderObject()->hasExpression($expression);
    }
    
    /**
     * @inheritDoc
     */
    public function hasExpressionHash($hashCode)
    {
        return $this->getBuilderObject()->hasExpressionHash($hashCode);
    }
    
    /**
     * @inheritDoc
     */
    public function getExpression($hashCode)
    {
        return $this->getBuilderObject()->getExpression($hashCode);
    }
    
    /**
     * @inheritDoc
     */
    public function getExpressions()
    {
        return $this->getBuilderObject()->getExpressions();
    }
    
    /**
     * @inheritDoc
     */
    public function getAliases()
    {
        return $this->getBuilderObject()->getAliases();
    }
    
    /**
     * @inheritDoc
     */
    public function hasAlias($alias)
    {
        return $this->getBuilderObject()->hasAlias($alias);
    }
    
    /**
     * @inheritDoc
     */
    public function getAlias($hash)
    {
        return $this->getBuilderObject()->getAlias($hash);
    }
    
    /**
     * @inheritDoc
     */
    public function getHashes()
    {
        return $this->getBuilderObject()->getHashes();
    }
    
    /**
     * @inheritDoc
     */
    public function hasHash($hashCode)
    {
        return $this->getBuilderObject()->hasHash($hashCode);
    }
    
    /**
     * @inheritDoc
     */
    public function getHash($alias)
    {
        return $this->getBuilderObject()->getHash($alias);
    }
    
    /**
     * @inheritDoc
     */
    public function getPlaceholders()
    {
        return $this->getBuilderObject()->getPlaceholders();
    }
    
    /**
     * @inheritDoc
     */
    public function setPlaceholder($hashCode, Expr\Raw $placeholder)
    {
        $this->getBuilderObject()->setPlaceholder($hashCode, $placeholder);
        
        return $this;
    }
    
    /**
     * @inheritDoc
     */
    public function getPlaceholder($hashCode)
    {
        return $this->getBuilderObject()->getPlaceholder($hashCode);
    }
    
    /**
     * @inheritDoc
     */
    public function getPlaceholderForExpression(Expression $expression)
    {
        return $this->getBuilderObject()->getPlaceholderForExpression($expression);
    }
    
    /**
     * @inheritDoc
     */
    public function quoteIdentifier($string)
    {
        return $this->getBuilderObject()->quoteIdentifier($string);
    }
    
    /**
     * @inheritDoc
     */
    public function getConnection()
    {
        return $this->getBuilderObject()->getConnection();
    }
    
    /**
     * @inheritDoc
     */
    public function setConnection(ConnectionInterface $connection)
    {
        $this->getBuilderObject()->setConnection($connection);
        
        return $this;
    }
    
    /**
     * @inheritDoc
     */
    public function getComment()
    {
        return $this->getBuilderObject()->getComment();
    }
    
    /**
     * @inheritDoc
     */
    public function getCommentSql()
    {
        return $this->getBuilderObject()->getCommentSql();
    }
    
    /**
     * @inheritDoc
     */
    public function setComment($comment)
    {
        $this->getBuilderObject()->setComment($comment);
        
        return $this;
    }
    
    /**
     * @return BuilderInterface
     */
    abstract public function getBuilderObject();
    
}