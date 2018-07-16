<?php

namespace Colibri\Core\Domain;

use Colibri\Core\Metadata;
use Colibri\Schema\Field;
use Colibri\Schema\Types\Type;

/**
 * Interface MetadataInterface
 * @package Colibri\Core\Domain
 */
interface MetadataInterface
{
    
    /**
     * @return string
     */
    public function getTableName();
    
    /**
     * @return string
     */
    public function getIdentifier();
    
    /**
     * @return string
     */
    public function getConnectionName();
    
    /**
     * @return string
     */
    public function getEntityRepositoryClass();
    
    /**
     * @return string
     */
    public function getEntityClass();
    
    /**
     * @return array
     */
    public function getNames();
    
    /**
     * @return array
     */
    public function getSQLNames();
    
    /**
     * @param        $name
     * @param string $format
     *
     * @return null|string
     */
    public function getName($name, $format = Metadata::RAW);
    
    /**
     * @param $name
     *
     * @return string|null
     */
    public function getSQLName($name);
    
    /**
     * @param $name
     *
     * @return string|null
     */
    public function getRawSQLName($name);
    
    /**
     * @return boolean
     */
    public function hasRelations();
    
    /**
     * @return array
     */
    public function getRelations();
    
    /**
     * @param $name
     *
     * @return null|array
     */
    public function getRelation($name);
    
    /**
     * @param $name
     *
     * @return Field
     */
    public function getColumnInstance($name);
    
    /**
     * @param $name
     *
     * @return Type
     */
    public function getColumnType($name);
    
    /**
     * @param $name
     * @param $value
     *
     * @return mixed
     */
    public function toPhp($name, $value);
    
    /**
     * @param $name
     * @param $value
     *
     * @return mixed
     */
    public function toPlatform($name, $value);
    
    /**
     * @return array
     */
    public function getSelectColumns();
    
    /**
     * @return array
     */
    public function getColumnsDefaultValues();
    
    /**
     * @return mixed
     */
    public function getNullableColumns();
    
    /**
     * @return mixed
     */
    public function getUnsignedColumns();
    
    /**
     * @return mixed
     */
    public function getPrimaryColumns();
    
    /**
     * @return mixed
     */
    public function getColumnsEnumValues();
    
    /**
     * @param $name
     *
     * @return string
     */
    public function isUnsigned($name);
    
    /**
     * @param $name
     *
     * @return string
     */
    public function isNullable($name);
    
    /**
     * @param $name
     *
     * @return string
     */
    public function isPrimary($name);
    
}