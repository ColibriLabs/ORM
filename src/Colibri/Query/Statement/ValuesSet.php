<?php

namespace Colibri\Query\Statement;

use Colibri\Collection\Collection;
use Colibri\Query\Builder;
use Colibri\Query\Expr;

/**
 * Class ValuesSet
 * @package Colibri\Query\Statement
 */
class ValuesSet extends AbstractStatement
{
  
  use Builder\Syntax\ValuesSetTrait;
  
  /**
   * @var Collection|Collection[]
   */
  protected $dataSet;
  
  /**
   * ValuesSet constructor.
   * @param Builder $builder
   */
  public function __construct(Builder $builder)
  {
    parent::__construct($builder);
    
    $this->dataSet = new Collection([
      'valuesSet'     => new Collection(),
      'columnHashes'  => new Collection(),
    ]);
  }
  
  /**
   * @return string
   */
  public function toSQL()
  {
    $template = '(%s) VALUES %s';
    $values = $columns = [];

    foreach ($this->dataSet['valuesSet'] as $valuesSet) {
      $values[] = sprintf('(%s)', implode(', ', array_map(function($valueItem) {
        return $this->stringifyExpression($valueItem);
      }, $valuesSet)));
    }

    foreach ($this->dataSet['columnHashes'] as $columnHash) {
      $columnExpression = $this->getBuilder()->getExpression($columnHash);
      $columns[] = $this->stringifyExpression($columnExpression);
    }

    return sprintf($template, implode(', ', $columns), implode(', ', $values));
  }
  
  /**
   * @param array $values
   * @return $this
   */
  public function setInsertData(array $values)
  {
    $this->dataSet['valuesSet']->add(array_map(function($value) {
      return new Expr\Parameter($value);
    }, $values));
    
    if ($this->dataSet['columnHashes']->count() == 0) {
      $columns = array_map(function($columnName) {
        $columnExpression = $this->normalizeExpression(new Expr\Column($columnName));
        return $columnExpression->hashCode();
      }, array_keys($values));
      
      $this->dataSet['columnHashes']->batch($columns);
    }

    return $this;
  }
  
  /**
   * @return $this
   */
  public function getValuesSetStatement()
  {
    return $this;
  }
  
}