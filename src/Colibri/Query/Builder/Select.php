<?php

namespace Colibri\Query\Builder;

use Colibri\Collection\ArrayCollection;
use Colibri\Connection\ConnectionInterface;
use Colibri\Exception\BadArgumentException;
use Colibri\Query\Builder;
use Colibri\Query\Expr;
use Colibri\Query\Expr\Func;
use Colibri\Query\Expression;
use Colibri\Query\Statement\GroupBy;
use Colibri\Query\Statement\Having;
use Colibri\Query\Statement\Joins;
use Colibri\Query\Statement\Limit;
use Colibri\Query\Statement\Modifiers;
use Colibri\Query\Statement\OrderBy;
use Colibri\Query\Statement\Where;

/**
 * Class Select
 * @package Colibri\Query\Builder
 */
class Select extends Builder
{

  use Syntax\WhereTrait;
  use Syntax\GroupByTrait;
  use Syntax\OrderByTrait;
  use Syntax\ModifiersTrait;
  use Syntax\HavingTrait;
  use Syntax\JoinTrait;
  use Syntax\LimitTrait;

  /**
   * @var string
   */
  const TEMPLATE = 'SELECT%s%s%s%s%s%s%s%s%s';

  /**
   * @var ArrayCollection
   */
  protected $columns = null;

  /**
   * Select constructor.
   * @param ConnectionInterface $connection
   */
  public function __construct(ConnectionInterface $connection)
  {
    parent::__construct($connection);

    $this->columns = new ArrayCollection();
  }

  /**
   * Cloning object
   */
  public function __clone()
  {
    parent::__clone();

    $this->columns = clone $this->columns;
    $this->statements = clone $this->statements;
  }

  /**
   * @return array
   */
  public function __debugInfo()
  {
    return [
      'builder_name' => __CLASS__,
      'parent_builder' => parent::__debugInfo(),
      'columns' => $this->columns->toArray(),
      'statements' => $this->statements,
    ];
  }

  /**
   * @inheritDoc
   */
  protected function initialize()
  {
    parent::initialize();

    $this->columns = new ArrayCollection();
    $this->statements = new ArrayCollection([
      'modifiers' => new Modifiers($this, Modifiers::MAP_SELECT),
      'joins' => new Joins($this),
      'where' => new Where($this),
      'group' => new GroupBy($this),
      'order' => new OrderBy($this),
      'having' => new Having($this),
      'limit' => new Limit($this),
    ]);
  }

  /**
   * @param string $table
   * @return Select
   */
  public function from($table)
  {
    return $this->table($table);
  }

  /**
   * @param string $table
   * @return Select
   */
  public function setFromTable($table)
  {
    return $this->from($table);
  }

  /**
   * @param array $columns
   * @return Select
   */
  public function addSelectColumns(array $columns)
  {
    foreach ($columns as $column) {
      is_array($column)
        ? count($column) != count($column, true)
          ? $this->addSelectColumns(...$column)
          : $this->addSelectColumn(...$column)
        : $this->addSelectColumn($column);
    }

    return $this;
  }

  /**
   * @param string $expression
   * @param null $alias
   * @return $this
   */
  public function addSelectColumn($expression, $alias = null)
  {
    if (!($expression instanceof Expression)) {
      $expression = new Expr\Column($expression);
    }

    $this->registerExpression($expression, $alias);

    $this->columns->add($expression->hashCode());

    return $this;
  }

  /**
   * @return $this
   */
  public function clearSelectColumns()
  {
    $this->columns->clear();

    return $this;
  }

  /**
   * @param string $column
   * @param string $alias
   * @return Select
   */
  public function avg($column, $alias)
  {
    return $this->addSelectColumn(new Func\Avg(new Expr\Column($column)), $alias);
  }

  /**
   * @param $column
   * @param $alias
   * @return Select
   */
  public function count($column, $alias)
  {
    return $this->addSelectColumn(new Func\Count(new Expr\Column($column)), $alias);
  }

  /**
   * @param $column
   * @param $alias
   * @return Select
   */
  public function max($column, $alias)
  {
    return $this->addSelectColumn(new Func\Max(new Expr\Column($column)), $alias);
  }

  /**
   * @param $column
   * @param $alias
   * @return Select
   */
  public function min($column, $alias)
  {
    return $this->addSelectColumn(new Func\Min(new Expr\Column($column)), $alias);
  }

  /**
   * @return GroupBy
   * @throws BadArgumentException
   */
  public function getGroupByStatement()
  {
    return $this->statements['group'];
  }

  /**
   * @return Having
   * @throws BadArgumentException
   */
  public function getHavingStatement()
  {
    return $this->statements['having'];
  }

  /**
   * @return Modifiers
   * @throws BadArgumentException
   */
  public function getModifiersStatement()
  {
    return $this->statements['modifiers'];
  }

  /**
   * @return Joins
   * @throws BadArgumentException
   */
  public function getJoinStatement()
  {
    return $this->statements['joins'];
  }

  /**
   * @return OrderBy
   * @throws BadArgumentException
   */
  public function getOrderByStatement()
  {
    return $this->statements['order'];
  }

  /**
   * @return Where
   * @throws BadArgumentException
   */
  public function getWhereStatement()
  {
    return $this->statements['where'];
  }

  /**
   * @return Limit
   */
  public function getLimitStatement()
  {
    return $this->statements['limit'];
  }

  /**
   * @return string
   */
  public function toSQL()
  {
    $statements = [];

    /** @var Expr\Parameters $parameters */
    $expressions = $this->columns->map(function ($hashCode) {
      return $this->getExpression($hashCode);
    })->toArray();

    $columns = (string) $this->normalizeExpression(new Expr\Parameters($expressions));

    $statementsNames = [
      'joins' => "\n%s",
      'where' => "\nWHERE %s",
      'group' => "\nGROUP BY %s",
      'order' => "\nORDER BY %s",
      'having' => "\nHAVING %s",
      'limit' => "\nLIMIT %s",
    ];

    $statements[] = (null === ($modifiers = $this->getModifiersStatement()->toSQL())) ? null : $modifiers;
    $statements[] = " $columns ";
    $statements[] = $this->table->getName() ? "\nFROM {$this->table->toSQL()}" : null;

    foreach ($statementsNames as $name => $template) {
      if (null !== ($statement = $this->statements->get($name)) && null !== ($statementSQL = $statement->toSQL())) {
        $statements[] = sprintf($template, $statementSQL);
      } else {
        $statements[] = null;
      }
    }

    return $this->getCommentSql() . sprintf(static::TEMPLATE, ...$statements);
  }
}