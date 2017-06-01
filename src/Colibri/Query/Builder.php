<?php

namespace Colibri\Query;

use Colibri\Collection\Collection;
use Colibri\Connection\ConnectionInterface;
use Colibri\Query\Expr;
use Colibri\Query\Statement\AbstractStatement;

/**
 * Class Builder
 * @package Colibri\Query
 */
abstract class Builder implements SqlableInterface
{

  /**
   * @var bool
   */
  protected $replaceAliases = false;

  /**
   * @var null|string
   */
  protected $comment = null;

  /**
   * @var ConnectionInterface
   */
  protected $connection = null;

  /**
   * @var Expr\Table $table
   */

  protected $table = null;

  /**
   * @var Collection|Collection[]|Expression[][]
   */
  protected $map = null;

  /**
   * @var Collection
   */
  protected $statements;
  
  /**
   * @var bool
   */
  protected $parameterized = false;
  
  /**
   * @var int
   */
  protected $parameterCounter = 0;
  
  /**
   * @var array
   */
  protected $parametersMap = [];

  /**
   * Builder constructor.
   * @param ConnectionInterface $connection
   */
  public function __construct(ConnectionInterface $connection)
  {
    $this->connection = $connection;
    $this->initialize();
  }

  /**
   * Clone operations
   */
  public function __clone()
  {
    $this->map = clone $this->map;

    $statements = new Collection();
    foreach ($this->statements as $name => $statement) {
      /** @var AbstractStatement $statement */
      $statement->setBuilder($this);
      $statements->set($name, clone $statement);
    }
    $this->statements = $statements;
  }

  /**
   * @return array
   */
  public function __debugInfo()
  {
    return [
      'table' => $this->table->format(),
      'map' => $this->map->toArray(),
    ];
  }

  /**
   * The __toString method allows a class to decide how it will react when it is converted to a string.
   *
   * @return string
   * @link http://php.net/manual/en/language.oop5.magic.php#language.oop5.magic.tostring
   */
  function __toString()
  {
    try {
      return $this->toSQL();
    } catch (\Exception $exception) {
      return $exception->getMessage();
    }
  }

  /**
   * @return void
   */
  protected function initialize()
  {
    $this->map = new Collection([
      'expressions' => new Collection(),
      'aliases' => new Collection(),
      'hashes' => new Collection(),
    ]);
  }

  /**
   * @param $table
   * @return $this
   */
  public function table($table)
  {
    $table = is_array($table) ? $table : [$table];

    $this->table = $this->createTable(...$table);

    return $this;
  }

  /**
   * @return $this
   */
  public function cleanup()
  {
    $this->initialize();

    return $this;
  }

  /**
   * @return boolean
   */
  public function isReplaceAliases()
  {
    return $this->replaceAliases;
  }

  /**
   * @param boolean $replaceAliases
   */
  public function setReplaceAliases($replaceAliases)
  {
    $this->replaceAliases = $replaceAliases;
  }
  
  /**
   * @return bool
   */
  public function isParameterized()
  {
    return $this->parameterized;
  }
  
  /**
   * @param bool $parameterized
   * @return $this
   */
  public function setParameterized($parameterized)
  {
    $this->parameterized = $parameterized;
    
    return $this;
  }
  
  /**
   * @param Expression $expression
   * @return string
   */
  public function stringifyExpression(Expression $expression)
  {
    return (string) $this->normalizeExpression($expression);
  }

  /**
   * @param Expression $expression
   * @return Expression
   */
  public function normalizeExpression(Expression $expression)
  {
    $this->registerExpression($expression);

    switch (true) {
      case $expression instanceof Expr\Parameter:
    
        if ($this->isParameterized()) {
          $placeholder = new Expr\Raw(':p' . $this->parameterCounter++);
          $this->parametersMap[(string)$placeholder] = $expression->toSQL();
      
          return $placeholder;
        }
    
        return $expression;
        
      case $expression instanceof Expr\Parameters:
      case $expression instanceof Expr\Func:

        $parameters = ($expression instanceof Expr\Func)
          ? (new Expr\Parameters($expression->getParameters()))->getParameters()
          : $expression->getParameters();

        foreach ($parameters as &$parameter) {
          $parameter = $this->normalizeExpression($parameter);
        }

        $expression->setParameters($parameters);

        return $expression;

      case $expression instanceof Expr\Column:

        if($this->isReplaceAliases() === true) {

          if($this->hasColumnAlias($expression->getName())) {
            if(null !== ($normalized = $this->getColumnByAlias($expression->getName()))) {
              $expression->setName($normalized->getName())->setTable($normalized->getTable());
            }
          }

          if($this->hasTableAlias($expression->getTable())) {
            if (null !== ($table = $this->getTableByAlias($expression->getTable()))) {
              $expression->setTable($table->getName())->setDatabase($table->getDatabase());
            }
          }

        }

        return $expression;

      default:
        return $expression;
    }
  }

  /**
   * @param $definition
   * @param null $alias
   * @return Expression
   */
  public function createTable($definition, $alias = null)
  {
    return $this->registerExpression(new Expr\Table($definition), $alias);
  }

  /**
   * @param $definition
   * @param null $alias
   * @return Expression
   */
  public function createColumn($definition, $alias = null)
  {
    return $this->registerExpression(new Expr\Column($definition), $alias);
  }

  /**
   * @param Expression $expression
   * @param null $alias
   * @return Expression
   */
  public function registerExpression(Expression $expression, $alias = null)
  {
    (null === $alias)
      ? $this->setExpression($expression) : $this->setAlias($expression, $alias);

    return $expression->setBuilder($this);
  }

  /**
   * @param $alias
   * @return bool
   */
  public function hasColumnAlias($alias)
  {
    return $this->hasAlias($alias) && $this->getExpression($this->getHash($alias)) instanceof Expr\Column;
  }

  /**
   * @param $alias
   * @return bool
   */
  public function hasTableAlias($alias)
  {
    return $this->hasAlias($alias) && $this->getExpression($this->getHash($alias)) instanceof Expr\Table;
  }

  /**
   * @param $alias
   * @return bool
   */
  public function hasFunctionAlias($alias)
  {
    return $this->hasAlias($alias) && $this->getExpression($this->getHash($alias)) instanceof Expr\Func;
  }

  /**
   * @param $alias
   * @return bool
   */
  public function hasSubqueryAlias($alias)
  {
    return $this->hasAlias($alias) && $this->getExpression($this->getHash($alias)) instanceof Expr\Subquery;
  }

  /**
   * @param string $alias
   * @return Expr\Column
   */
  public function getColumnByAlias($alias)
  {
    return $this->hasColumnAlias($alias) ? $this->getExpression($this->getHash($alias)) : null;
  }

  /**
   * @param string $alias
   * @return Expr\Table
   */
  public function getTableByAlias($alias)
  {
    return $this->hasTableAlias($alias) ? $this->getExpression($this->getHash($alias)) : null;
  }

  /**
   * @param $alias
   * @return Expr\Func|null
   */
  public function getFunctionByAlias($alias)
  {
    return $this->hasFunctionAlias($alias) ? $this->getExpression($this->getHash($alias)) : null;
  }

  /**
   * @param $alias
   * @return Expr\Subquery|null
   */
  public function getSubqueryByAlias($alias)
  {
    return $this->hasSubqueryAlias($alias) ? $this->getExpression($this->getHash($alias)) : null;
  }

  /**
   * @param Expr\Column $column
   * @param $alias
   * @return Builder
   */
  public function setColumnAlias(Expr\Column $column, $alias)
  {
    return $this->setAlias($column, $alias);
  }

  /**
   * @param Expr\Table $table
   * @param $alias
   * @return Builder
   */
  public function setTableAlias(Expr\Table $table, $alias)
  {
    return $this->setAlias($table, $alias);
  }

  /**
   * @param Expr\Func $function
   * @param $alias
   * @return Builder
   */
  public function setFunctionAlias(Expr\Func $function, $alias)
  {
    return $this->setAlias($function, $alias);
  }

  /**
   * @param Expression $expression
   * @param $alias
   * @return $this
   */
  public function setAlias(Expression $expression, $alias)
  {
    $this->map['hashes']->set($expression->hashCode(), $alias);
    $this->map['aliases']->set($alias, $expression->hashCode());

    $this->hasExpression($expression) || $this->setExpression($expression);

    return $this;
  }

  /**
   * @param Expression $expression
   * @return $this
   */
  public function setExpression(Expression $expression)
  {
    $this->map['expressions']->set($expression->hashCode(), $expression);

    return $this;
  }

  /**
   * @param Expression $expression
   * @return bool
   */
  public function hasExpression(Expression $expression)
  {
    return $this->hasExpressionHash($expression->hashCode());
  }

  /**
   * @param $hashCode
   * @return bool
   */
  public function hasExpressionHash($hashCode)
  {
    return $this->map['expressions']->has($hashCode);
  }

  /**
   * @param $hashCode
   * @return mixed|null
   */
  public function getExpression($hashCode)
  {
    return $this->map['expressions']->get($hashCode);
  }

  /**
   * @return Collection|Expression[]|mixed|null
   */
  public function getExpressions()
  {
    return $this->map['expressions'];
  }

  /**
   * @return Collection|Expression[]|mixed|null
   */
  public function getAliases()
  {
    return $this->map['aliases'];
  }

  /**
   * @param $alias
   * @return bool
   */
  public function hasAlias($alias)
  {
    return $this->map['aliases']->has($alias);
  }

  /**
   * @param $hash
   * @return Expression|mixed|null
   */
  public function getAlias($hash)
  {
    return $this->map['hashes'][$hash];
  }

  /**
   * @return Collection|Expression[]|mixed|null
   */
  public function getHashes()
  {
    return $this->map['hashes'];
  }

  /**
   * @param $hashCode
   * @return bool
   */
  public function hasHash($hashCode)
  {
    return $this->map['hashes']->has($hashCode);
  }

  /**
   * @param $alias
   * @return Expression|mixed|null
   */
  public function getHash($alias)
  {
    return $this->map['aliases'][$alias];
  }

  /**
   * @param $string
   * @return string
   */
  public function quoteIdentifier($string)
  {
    return null === $string ? null : $this->connection->quoteIdentifier($string);
  }

  /**
   * @return ConnectionInterface
   */
  public function getConnection()
  {
    return $this->connection;
  }

  /**
   * @param ConnectionInterface $connection
   * @return Builder
   */
  public function setConnection(ConnectionInterface $connection)
  {
    $this->connection = $connection;

    return $this;
  }

  /**
   * @return null|string
   */
  public function getComment()
  {
    return $this->comment;
  }

  /**
   * @return null|string
   */
  public function getCommentSql()
  {
    $comment = $this->getComment();

    if(null !== $this->comment) {
      $comment = str_replace("\n", "\n-- ", $this->comment);
      $comment = "-- $comment\n";
    }

    return $comment;
  }

  /**
   * @param null|string $comment
   */
  public function setComment($comment)
  {
    $this->comment = (string) $comment;
  }

}