<?php

namespace Colibri\Schema;

/**
 * Class Relation
 * @package Colibri\Schema
 */
class Relation
{

  /**
   * @var string
   */
  protected $associationType;

  /**
   * @var string
   */
  protected $localTable;

  /**
   * @var string
   */
  protected $foreignTable;

  /**
   * @var string
   */
  protected $localField;

  /**
   * @var string
   */
  protected $foreignField;

  /**
   * @var string
   */
  protected $relationName;

  /**
   * Relation constructor.
   */
  public function __construct()
  {

  }

  /**
   * @return string
   */
  public function getAssociationType()
  {
    return $this->associationType;
  }

  /**
   * @param string $associationType
   */
  public function setAssociationType($associationType)
  {
    $this->associationType = $associationType;
  }

  /**
   * @return string
   */
  public function getLocalTable()
  {
    return $this->localTable;
  }

  /**
   * @param string $localTable
   */
  public function setLocalTable($localTable)
  {
    $this->localTable = $localTable;
  }

  /**
   * @return string
   */
  public function getForeignTable()
  {
    return $this->foreignTable;
  }

  /**
   * @param string $foreignTable
   */
  public function setForeignTable($foreignTable)
  {
    $this->foreignTable = $foreignTable;
  }

  /**
   * @return string
   */
  public function getLocalField()
  {
    return $this->localField;
  }

  /**
   * @param string $localField
   */
  public function setLocalField($localField)
  {
    $this->localField = $localField;
  }

  /**
   * @return string
   */
  public function getForeignField()
  {
    return $this->foreignField;
  }

  /**
   * @param string $foreignField
   */
  public function setForeignField($foreignField)
  {
    $this->foreignField = $foreignField;
  }

  /**
   * @return string
   */
  public function getRelationName()
  {
    return $this->relationName;
  }

  /**
   * @param string $relationName
   */
  public function setRelationName($relationName)
  {
    $this->relationName = $relationName;
  }

}