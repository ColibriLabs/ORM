<?php

namespace Colibri\Schema;

use Colibri\Collection\Collection;
use Colibri\Common\ArrayableInterface;
use Colibri\Common\Inflector;

/**
 * Class Table
 * @package Colibri\Schema
 */
class Table implements ArrayableInterface
{

  /**
   * @var string
   */
  protected $tableName;

  /**
   * @var string
   */
  protected $name;

  /**
   * @var Collection
   */
  protected $fields;

  /**
   * @var null|Relation[]
   */
  protected $relations;

  /**
   * Table constructor.
   * @param $tableName
   */
  public function __construct($tableName)
  {
    $this->tableName = $tableName;
    $this->fields = new Collection();
  }

  /**
   * @return string
   */
  public function getTableName()
  {
    return $this->tableName;
  }

  /**
   * @param string $tableName
   * @return $this
   */
  public function setTableName($tableName)
  {
    $this->tableName = $tableName;

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
   * @return string
   */
  public function getClassifyName()
  {
    return Inflector::classify($this->getName());
  }

  /**
   * @return string
   */
  public function getConstantName()
  {
    return Inflector::constantify($this->getName());
  }

  /**
   * @return string
   */
  public function getCamelizeName()
  {
    return Inflector::camelize($this->getName());
  }

  /**
   * @param string $name
   * @return $this
   */
  public function setName($name)
  {
    $this->name = $name;

    return $this;
  }

  /**
   * @return Collection|Field[]
   */
  public function getFields()
  {
    return $this->fields;
  }

  /**
   * @param $name
   * @return Field|null
   */
  public function getField($name)
  {
    return $this->fields->has($name) ? $this->fields[$name] : null;
  }

  /**
   * @param Field $field
   * @return $this
   */
  public function addField(Field $field)
  {
    $this->fields->set($field->getColumn(), $field);

    return $this;
  }

  /**
   * @param $name
   * @return $this
   */
  public function removeField($name)
  {
    $this->fields->remove($name);

    return $this;
  }

  /**
   * @return Relation[]|null
   */
  public function getRelations()
  {
    return $this->relations;
  }

  /**
   * @param Relation[]|null $relations
   */
  public function setRelations(array $relations)
  {
    $this->relations = $relations;
  }

  /**
   * @param Relation $relation
   * @return $this
   */
  public function addRelation(Relation $relation)
  {
    $this->relations[] = $relation;

    return $this;
  }

  /**
   * @return bool
   */
  public function hasRelation()
  {
    return count($this->relations) > 0;
  }

  /**
   * @return array
   */
  public function toArray()
  {
    $fields = [];

    $this->fields->each(function(Field $field) use (&$fields) {
      $fields[$field->getColumn()] = $field->toArray();
    });

    return [
      'table_name' => $this->getTableName(),
      'fields' => $fields,
    ];
  }

}