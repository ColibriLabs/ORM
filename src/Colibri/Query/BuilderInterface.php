<?php
/**
 * Created by PhpStorm.
 * User: gontarenko
 * Date: 1/4/2018
 * Time: 11:57 AM
 */

namespace Colibri\Query;

use Colibri\Collection\Collection;
use Colibri\Connection\ConnectionInterface;

/**
 * Class Builder
 * @package Colibri\Query
 */
interface BuilderInterface
{
    
    /**
     * @param $table
     *
     * @return $this
     */
    public function table($table);
    
    /**
     * @return $this
     */
    public function cleanup();
    
    /**
     * @return boolean
     */
    public function isReplaceAliases();
    
    /**
     * @param boolean $replaceAliases
     */
    public function setReplaceAliases($replaceAliases);
    
    /**
     * @return bool
     */
    public function isParameterized();
    
    /**
     * @param bool $parameterized
     *
     * @return $this
     */
    public function setParameterized($parameterized);
    
    /**
     * @param Expression $expression
     *
     * @return string
     */
    public function stringifyExpression(Expression $expression);
    
    /**
     * @param Expression $expression
     *
     * @return Expression
     */
    public function normalizeExpression(Expression $expression);
    
    /**
     * @param Expression $expression
     *
     * @return Expr\Raw|Expression
     */
    public function postProcessExpression(Expression $expression);
    
    /**
     * @param Expression $expression
     *
     * @return Expression
     */
    public function preProcessExpression(Expression $expression);
    
    /**
     * @param Expression $expression
     * @param null       $alias
     *
     * @return Expression
     */
    public function completeExpression(Expression $expression, $alias = null);
    
    /**
     * @param $definition
     *
     * @return Expression
     */
    public function createTable($definition);
    
    /**
     * @param $definition
     *
     * @return Expression
     */
    public function createColumn($definition);
    
    /**
     * @param $alias
     *
     * @return bool
     */
    public function hasColumnAlias($alias);
    
    /**
     * @param $alias
     *
     * @return bool
     */
    public function hasTableAlias($alias);
    
    /**
     * @param $alias
     *
     * @return bool
     */
    public function hasFunctionAlias($alias);
    
    /**
     * @param $alias
     *
     * @return bool
     */
    public function hasSubqueryAlias($alias);
    
    /**
     * @param string $alias
     *
     * @return Expr\Column
     */
    public function getColumnByAlias($alias);
    
    /**
     * @param string $alias
     *
     * @return Expr\Table
     */
    public function getTableByAlias($alias);
    
    /**
     * @param $alias
     *
     * @return Expr\Func|null
     */
    public function getFunctionByAlias($alias);
    
    /**
     * @param $alias
     *
     * @return Expr\Subquery|null
     */
    public function getSubqueryByAlias($alias);
    
    /**
     * @param Expr\Column $column
     * @param             $alias
     *
     * @return Builder
     */
    public function setColumnAlias(Expr\Column $column, $alias);
    
    /**
     * @param Expr\Table $table
     * @param            $alias
     *
     * @return Builder
     */
    public function setTableAlias(Expr\Table $table, $alias);
    
    /**
     * @param Expr\Func $function
     * @param           $alias
     *
     * @return Builder
     */
    public function setFunctionAlias(Expr\Func $function, $alias);
    
    /**
     * @param Expression $expression
     * @param            $alias
     *
     * @return $this
     */
    public function setAlias(Expression $expression, $alias);
    
    /**
     * @param Expression $expression
     *
     * @return $this
     */
    public function setExpression(Expression $expression);
    
    /**
     * @param Expression $expression
     *
     * @return bool
     */
    public function hasExpression(Expression $expression);
    
    /**
     * @param $hashCode
     *
     * @return bool
     */
    public function hasExpressionHash($hashCode);
    
    /**
     * @param $hashCode
     *
     * @return mixed|null
     */
    public function getExpression($hashCode);
    
    /**
     * @return Collection|Expression[]|mixed|null
     */
    public function getExpressions();
    
    /**
     * @return Collection|Expression[]|mixed|null
     */
    public function getAliases();
    
    /**
     * @param $alias
     *
     * @return bool
     */
    public function hasAlias($alias);
    
    /**
     * @param $hash
     *
     * @return Expression|mixed|null
     */
    public function getAlias($hash);
    
    /**
     * @return Collection|Expression[]|mixed|null
     */
    public function getHashes();
    
    /**
     * @param $hashCode
     *
     * @return bool
     */
    public function hasHash($hashCode);
    
    /**
     * @param $alias
     *
     * @return Expression|mixed|null
     */
    public function getHash($alias);
    
    /**
     * @return array
     */
    public function getPlaceholders();
    
    /**
     * @param          $hashCode
     * @param Expr\Raw $placeholder
     *
     * @return $this
     */
    public function setPlaceholder($hashCode, Expr\Raw $placeholder);
    
    /**
     * @param $hashCode
     *
     * @return Expr\Raw|null
     */
    public function getPlaceholder($hashCode);
    
    /**
     * @param Expression $expression
     *
     * @return Expr\Raw|null
     */
    public function getPlaceholderForExpression(Expression $expression);
    
    /**
     * @param $string
     *
     * @return string
     */
    public function quoteIdentifier($string);
    
    /**
     * @return ConnectionInterface
     */
    public function getConnection();
    
    /**
     * @param ConnectionInterface $connection
     *
     * @return Builder
     */
    public function setConnection(ConnectionInterface $connection);
    
    /**
     * @return null|string
     */
    public function getComment();
    
    /**
     * @return null|string
     */
    public function getCommentSql();
    
    /**
     * @param null|string $comment
     */
    public function setComment($comment);
}