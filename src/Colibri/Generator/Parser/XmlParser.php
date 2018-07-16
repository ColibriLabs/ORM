<?php

namespace Colibri\Generator\Parser;

use Colibri\Schema\Field;
use Colibri\Schema\Platform;
use Colibri\Schema\Relation;
use Colibri\Schema\Table;
use Colibri\Schema\Types\DatetimeType;
use Colibri\Schema\Types\EnumType;
use Colibri\Schema\Types\SimpleArrayType;
use Colibri\Schema\Types\Type;

/**
 * Class XmlParser
 * @package Colibri\Generator\Parser
 */
class XmlParser extends DriverAbstract
{
    
    /**
     * @var \SimpleXMLElement
     */
    protected $xmlElement;
    
    /**
     * XmlParser constructor.
     *
     * @param \SimpleXMLElement $simpleXMLElement
     */
    public function __construct(\SimpleXMLElement $simpleXMLElement)
    {
        parent::__construct();
        
        $this->xmlElement = $simpleXMLElement;
    }
    
    /**
     * @return $this
     */
    public function parse()
    {
        if ($this->xmlElement->getName() === 'database') {
            $attributes = (array) $this->xmlElement->attributes();
            $attributes = $attributes['@attributes'];
            
            $this->schema->setName($attributes['name']);
            $this->schema->setPackage($attributes['package']);
            $this->schema->setPlatform(Platform::factory($attributes['platform']));
            
            $this->parseTables($this->xmlElement);
        }
        
        return $this;
    }
    
    /**
     * @param \SimpleXMLElement $element
     *
     * @return $this
     */
    protected function parseTables(\SimpleXMLElement $element)
    {
        /** @var \SimpleXMLElement $tableElement */
        foreach ($element as $tableElement) {
            $attributes = $tableElement->attributes();
            
            $tableName = (string) $attributes['table'];
            $tablePhpName = isset($attributes['name']) && !empty((string) $attributes['name'])
                ? (string) $attributes['name']
                : $tableName;
            
            $table = new Table($tableName);
            $table->setName($tablePhpName);
            
            $this->schema->addTable($table);
            $this->parseColumns($tableElement, $table);
            $this->parseRelations($tableElement, $table);
        }
        
        return $this;
    }
    
    /**
     * @param \SimpleXMLElement $elementColumns
     * @param Table             $table
     */
    protected function parseColumns(\SimpleXMLElement $elementColumns, Table $table)
    {
        /**
         * @var \SimpleXMLElement $columnElement
         */
        
        foreach ($elementColumns as $columnElement) {
            
            if ($columnElement->getName() !== 'column') {
                continue;
            }
            
            $attributes = (array) $columnElement->attributes();
            $attributes = $attributes['@attributes'];
            
            $columnName = $attributes['column'];
            $columnPhpName = isset($attributes['name']) && !empty($attributes['name'])
                ? (string) $attributes['name']
                : $columnName;
            
            $field = new Field($columnName);
            $field->setName($columnPhpName);
            
            $this->parseColumnType($field, $attributes);
            
            $field->setDefault(isset($attributes['default']) ? $attributes['default'] : null);
            $field->setUnsigned(isset($attributes['unsigned']) ? $this->stringToBoolean($attributes['unsigned']) : false);
            $field->setNullable(isset($attributes['nullable']) ? $this->stringToBoolean($attributes['nullable']) : false);
            $field->setAutoIncrement(isset($attributes['autoIncrement']) ? $this->stringToBoolean($attributes['autoIncrement']) : false);
            $field->setPrimaryKey(isset($attributes['primaryKey']) ? $this->stringToBoolean($attributes['primaryKey']) : false);
            $field->setIdentity(isset($attributes['identity']) ? $this->stringToBoolean($attributes['identity']) : false);
            
            $table->addField($field);
        }
    }
    
    /**
     * @param Field $field
     * @param array $attributes
     *
     * @return $this
     */
    protected function parseColumnType(Field $field, array $attributes)
    {
        $type = Type::retrieveTypeObject(strtolower($attributes['type']));
        
        $type->setLength(isset($attributes['length']) ? (integer) $attributes['length'] : 0);
        $type->setPrecision(isset($attributes['precision']) ? (integer) $attributes['precision'] : 0);
        
        switch (true) {
            case $type instanceof EnumType:
                $enumeration = explode(',', $attributes['enum']);
                $enumeration = array_map('trim', $enumeration);
                
                $type->setExtra($enumeration);
                break;
            
            case $type instanceof DatetimeType:
                if (isset($attributes['format'])) {
                    $type->setExtra(['format' => $attributes['format'],]);
                }
                break;
            
            case $type instanceof SimpleArrayType:
                if (isset($attributes['separator'])) {
                    $type->setExtra(['separator' => $attributes['separator'],]);
                }
                break;
            
            default:
                break;
        }
        
        $field->setType($type);
        
        return $this;
    }
    
    /**
     * @param $boolean
     *
     * @return bool
     */
    protected function stringToBoolean($boolean)
    {
        return in_array(strtolower($boolean), ['true', '1', 'yes']);
    }
    
    /**
     * @param \SimpleXMLElement $elementRelations
     * @param Table             $table
     */
    protected function parseRelations(\SimpleXMLElement $elementRelations, Table $table)
    {
        /**
         * @var \SimpleXMLElement $relationElement
         */
        
        foreach ($elementRelations as $relationElement) {
            
            if ($relationElement->getName() !== 'relation') {
                continue;
            }
            
            $attributes = (array) $relationElement->attributes();
            $attributes = $attributes['@attributes'];
            
            $relation = new Relation();
            
            $relation->setAssociationType($attributes['association']);
            $relation->setRelationName($attributes['name']);
            $relation->setLocalTable($table->getTableName());
            $relation->setForeignTable($attributes['table']);
            $relation->setLocalField($attributes['local']);
            $relation->setForeignField($attributes['foreign']);
            
            $table->addRelation($relation);
        }
    }
    
}