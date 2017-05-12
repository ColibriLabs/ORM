<?php

namespace Colibri\Core\Hydrator;

use Colibri\Collection\DataStructureCollection;

/**
 * @property string associationType
 * @property string relationName
 * @property string local
 * @property string target
 * @property string targetEntity
 * @property string localEntity
 */
class MappingStructure extends DataStructureCollection
{

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

  /**
   * @return string
   */
  public function getLocal()
  {
    return $this->local;
  }

  /**
   * @param string $local
   */
  public function setLocal($local)
  {
    $this->local = $local;
  }

  /**
   * @return string
   */
  public function getTarget()
  {
    return $this->target;
  }

  /**
   * @param string $target
   */
  public function setTarget($target)
  {
    $this->target = $target;
  }

  /**
   * @return string
   */
  public function getTargetEntity()
  {
    return $this->targetEntity;
  }

  /**
   * @param string $targetEntity
   */
  public function setTargetEntity($targetEntity)
  {
    $this->targetEntity = $targetEntity;
  }

  /**
   * @return string
   */
  public function getLocalEntity()
  {
    return $this->localEntity;
  }

  /**
   * @param string $localEntity
   */
  public function setLocalEntity($localEntity)
  {
    $this->localEntity = $localEntity;
  }

}