<?php

namespace Colibri\Core;

use Colibri\Collection\Collection;
use Colibri\Common\Inflector;
use Colibri\Core\Domain\MetadataInterface;
use Colibri\Exception\NotFoundException;
use Colibri\Schema\Field;
use Colibri\Schema\Types\Type as ColumnType;

/**
 * Class Metadata
 * @package Colibri\Core
 */
class Metadata implements MetadataInterface
{

  const ONE_TO_ONE = 'one_to_one';
  const ONE_TO_MANY = 'one_to_many';
  const MANY_TO_ONE = 'many_to_one';
  const MANY_TO_MANY = 'many_to_many';

  const CONNECTION_NAME = 'connectionName';
  const TABLE_NAME = 'tableName';
  const IDENTIFIER = 'identifier';

  const ENTITY_CLASS = 'entityClass';
  const REPOSITORY_CLASS = 'entityRepositoryClass';

  const RAW_NAMES = 'rawSQLNames';
  const NAMES = 'names';
  const RELATIONS = 'relations';

  const DEFAULT_VALUES = 'default';
  const ENUMERATIONS = 'enumerations';
  const NULLABLE = 'nullables';
  const UNSIGNED = 'unsigned';
  const PRIMARY = 'primary';

  const FIELD_INSTANCES = 'instances';
  
  const UNDERSCORED = 'U';
  const CAMILIZED = 'C';
  const CLASSIFIED = 'P';
  const RAW = 'R';

  /**
   * @var Collection
   */
  protected $metadata;

  /**
   * Metadata constructor.
   * @param array $metadata
   */
  public function __construct(array $metadata)
  {
    $this->metadata = new Collection($metadata);
  }

  /**
   * @return string
   */
  public function getTableName()
  {
    return $this->metadata[Metadata::TABLE_NAME];
  }

  /**
   * @return string
   */
  public function getIdentifier()
  {
    return $this->metadata[Metadata::IDENTIFIER];
  }

  /**
   * @return string
   */
  public function getConnectionName()
  {
    return $this->metadata[Metadata::CONNECTION_NAME];
  }

  /**
   * @return string
   */
  public function getEntityRepositoryClass()
  {
    return $this->metadata[Metadata::REPOSITORY_CLASS];
  }

  /**
   * @return string
   */
  public function getEntityClass()
  {
    return $this->metadata[Metadata::ENTITY_CLASS];
  }

  /**
   * @return array
   */
  public function getSelectColumns()
  {
    return $this->metadata[Metadata::RAW_NAMES];
  }

  /**
   * @return array
   */
  public function getNames()
  {
    return array_flip($this->getSQLNames());
  }

  /**
   * @return array
   */
  public function getSQLNames()
  {
    return $this->metadata[Metadata::NAMES];
  }
  
  /**
   * @param $name
   * @param string $format
   * @return null|string
   * @throws NotFoundException
   */
  public function getName($name, $format = Metadata::RAW)
  {
    $names = $this->getNames();

    if (isset($names[$name])) {
      switch ($format) {
        case Metadata::RAW:
          return $names[$name];
        case Metadata::CAMILIZED:
          return Inflector::camelize($names[$name]);
        case Metadata::CLASSIFIED:
          return Inflector::classify($names[$name]);
        case Metadata::UNDERSCORED:
          return Inflector::underscore($names[$name]);
        default:
          throw new NotFoundException('Unable to find correct inflector formatter');
      }
    }
  
    throw new NotFoundException(sprintf('Unable to find column name for "%s" with format "%s"',
      $name, $format));
  }

  /**
   * @param $name
   * @return null|string
   * @throws NotFoundException
   */
  public function getSQLName($name)
  {
    $names = $this->getSQLNames();

    if (isset($names[$name]))
      return $names[$name];

    throw new NotFoundException('Cannot found real column name for ":name"', ['name' => $name]);
  }

  /**
   * @param $name
   * @return mixed
   * @throws NotFoundException
   */
  public function getRawSQLName($name)
  {
    $names = $this->metadata[Metadata::RAW_NAMES];

    if (isset($names[$name]))
      return $names[$name];

    throw new NotFoundException('Cannot found real column name for ":name"', ['name' => $name]);
  }

  /**
   * @param $name
   * @return Field|null
   * @throws NotFoundException
   */
  public function getColumnInstance($name)
  {
    if (
      isset($this->metadata[Metadata::FIELD_INSTANCES][$name])
      && $this->metadata[Metadata::FIELD_INSTANCES][$name] instanceof Field
    ) {
      return $this->metadata[Metadata::FIELD_INSTANCES][$name];
    }

    throw new NotFoundException('Cannot found column definition for ":name"', ['name' => $name]);
  }

  /**
   * @param $name
   * @return ColumnType
   * @throws NotFoundException
   */
  public function getColumnType($name)
  {
    $columnInstance = $this->getColumnInstance($name);

    return $columnInstance->getType();
  }

  /**
   * @inheritDoc
   */
  public function toPhp($name, $value)
  {
    return $this->getColumnType($name)->toPhpValue($value);
  }

  /**
   * @inheritDoc
   */
  public function toPlatform($name, $value)
  {
    return $this->getColumnType($name)->toPlatformValue($value);
  }

  /**
   * @return bool
   */
  public function hasRelations()
  {
    return count($this->metadata[Metadata::RELATIONS]) > 0;
  }

  /**
   * @return array|null
   */
  public function getRelations()
  {
    return $this->metadata[Metadata::RELATIONS];
  }

  /**
   * @param $name
   * @return null|array
   */
  public function getRelation($name)
  {
    return isset($this->metadata[Metadata::RELATIONS][$name]) ? $this->metadata[Metadata::RELATIONS][$name] : null;
  }

  /**
   * @return array
   */
  public function getColumnsDefaultValues()
  {
    return $this->metadata[Metadata::DEFAULT_VALUES];
  }

  /**
   * @return array
   */
  public function getNullableColumns()
  {
    return $this->metadata[Metadata::NULLABLE];
  }

  /**
   * @return array
   */
  public function getUnsignedColumns()
  {
    return $this->metadata[Metadata::UNSIGNED];
  }

  /**
   * @return array
   */
  public function getPrimaryColumns()
  {
    return $this->metadata[Metadata::PRIMARY];
  }

  /**
   * @return array
   */
  public function getColumnsEnumValues()
  {
    return $this->metadata[Metadata::ENUMERATIONS];
  }
  
  /**
   * @inheritdoc
   */
  public function getColumnEnumValueSet($columnName)
  {
    $enumeration = $this->getColumnsEnumValues();
    
    if (!isset($enumeration[$columnName])) {
      throw new NotFoundException(sprintf('Enumeration for column "%s" was not found', $columnName));
    }
    
    $valueSet = $enumeration[$columnName];
    
    return array_combine($valueSet, $valueSet);
  }
  
  /**
   * @param $name
   * @return bool
   */
  public function isUnsigned($name)
  {
    return in_array($name, $this->getUnsignedColumns(), true);
  }

  /**
   * @param $name
   * @return bool
   */
  public function isNullable($name)
  {
    return in_array($name, $this->getNullableColumns(), true);
  }

  /**
   * @param $name
   * @return bool
   */
  public function isPrimary($name)
  {
    return in_array($name, $this->getPrimaryColumns(), true);
  }


}
