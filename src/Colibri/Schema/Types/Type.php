<?php

namespace Colibri\Schema\Types;

use Colibri\Exception\BadArgumentException;

/**
 * Class Type
 * @package Colibri\Schema\Types
 */
abstract class Type
{
  
  const TINYINT = 'tiny_integer';
  const SMALLINT = 'small_integer';
  const INTEGER = 'integer';
  const BIGINT = 'big_integer';
  const CHAR = 'char';
  const STRING = 'string';
  const TEXT = 'text';
  const NUMERIC = 'numeric';
  const DECIMAL = 'decimal';
  const BOOLEAN = 'boolean';
  const FLOAT = 'float';
  const DOUBLE = 'double';
  const BINARY = 'binary';
  const RESOURCE = 'resource';
  const BLOB = 'blob';
  const DATE = 'date';
  const TIME = 'time';
  const TIMESTAMP = 'timestamp';
  const ENUM = 'enum';
  const ARRAY_LIST = 'list';
  const DATA_ARRAY = 'array';
  const OBJECT = 'object';
  const JSON = 'json';
  const DATETIME = 'datetime';
  const UUID = 'uuid';
  
  protected static $typesMap = [
    self::TINYINT => IntegerType::class,
    self::SMALLINT => IntegerType::class,
    self::INTEGER => IntegerType::class,
    self::BIGINT => IntegerType::class,
    self::CHAR => StringType::class,
    self::STRING => StringType::class,
    self::TEXT => StringType::class,
    self::NUMERIC => IntegerType::class,
    self::DECIMAL => DoubleType::class,
    self::BOOLEAN => BooleanType::class,
    self::FLOAT => FloatType::class,
    self::DOUBLE => DoubleType::class,
    self::BINARY => ResourceType::class,
    self::BLOB => ResourceType::class,
    self::RESOURCE => ResourceStringType::class,
    self::DATE => DatetimeType::class,
    self::TIME => DatetimeType::class,
    self::TIMESTAMP => DatetimeType::class,
    self::ENUM => EnumType::class,
    self::DATA_ARRAY => ArrayType::class,
    self::ARRAY_LIST => SimpleArrayType::class,
    self::OBJECT => ObjectType::class,
    self::JSON => JsonType::class,
    self::DATETIME => DatetimeType::class,
    self::UUID => StringType::class,
  ];
  
  protected static $phpNamesMap = [
    self::TINYINT => 'boolean',
    self::SMALLINT => 'integer',
    self::INTEGER => 'integer',
    self::BIGINT => 'integer',
    self::CHAR => 'string',
    self::STRING => 'string',
    self::TEXT => 'string',
    self::NUMERIC => 'integer',
    self::DECIMAL => 'double',
    self::BOOLEAN => 'boolean',
    self::FLOAT => 'float',
    self::DOUBLE => 'double',
    self::BINARY => 'resource',
    self::BLOB => 'resource',
    self::RESOURCE => 'resource',
    self::DATE => 'string',
    self::TIME => 'integer',
    self::TIMESTAMP => 'integer',
    self::ENUM => 'string',
    self::DATA_ARRAY => 'array',
    self::ARRAY_LIST => 'array',
    self::OBJECT => 'object',
    self::JSON => 'string',
    self::DATETIME => 'string',
    self::UUID => 'string',
  ];
  
  /**
   * @var int
   */
  protected $length = 0;
  
  /**
   * @var int
   */
  protected $precision = 0;
  
  /**
   * @var null
   */
  protected $extra = null;
  
  /**
   * Type constructor.
   */
  public function __construct()
  {
    
  }
  
  /**
   * @param array $parameters
   * @return Type
   */
  public static function __set_state(array $parameters = [])
  {
    /** @var Type $instance */
    $reflection = new \ReflectionClass(static::class);
    $instance = $reflection->newInstance();
    
    foreach ($parameters as $name => $value) {
      if ($reflection->hasProperty($name) && $reflection->getProperty($name)->isProtected()) {
        $property = $reflection->getProperty($name);
        $property->setAccessible(true);
        $property->setValue($instance, $value);
      }
    }
    
    return $instance;
  }
  
  /**
   * @return string
   */
  public function getPhpName()
  {
    return static::$phpNamesMap[$this->getName()];
  }
  
  /**
   * @return int
   */
  public function getLength()
  {
    return $this->length;
  }
  
  /**
   * @return int
   */
  public function getPrecision()
  {
    return $this->precision;
  }
  
  /**
   * @param int $length
   */
  public function setLength($length)
  {
    $this->length = $length;
  }
  
  /**
   * @param int $precision
   */
  public function setPrecision($precision)
  {
    $this->precision = $precision;
  }
  
  /**
   * @return null
   */
  public function getExtra()
  {
    return $this->extra;
  }
  
  /**
   * @param null $extra
   */
  public function setExtra($extra)
  {
    $this->extra = $extra;
  }
  
  /**
   * @param $type
   * @return $this
   * @throws BadArgumentException
   */
  public static function retrieveTypeObject($type)
  {
    if (!array_key_exists($type, static::$typesMap)) {
      throw new BadArgumentException('Unable create column type object with name ":type" because cannot find it', [
        'type' => $type
      ]);
    }
    
    $class = static::$typesMap[$type];
    
    return new $class($type);
  }
  
  /**
   * @param string $name
   * @param string $class
   * @param string|null $phpTypeName
   * @throws BadArgumentException
   */
  public static function registerType($name, $class, $phpTypeName)
  {
    if (isset(static::$typesMap[$name])) {
      throw new BadArgumentException('Cannot register new type with name ":name" because it already registered', [
        'name' => $name
      ]);
    }
    
    static::overrideType($name, $class, $phpTypeName);
  }
  
  /**
   * @param string $name
   * @param string $class
   * @param string|null $phpTypeName
   * @throws BadArgumentException
   */
  public static function overrideType($name, $class, $phpTypeName = null)
  {
    if (!is_subclass_of($class, static::class)) {
      throw new BadArgumentException('Class :class should been subclass of :subClass', [
        'class' => $class, 'subClass' => static::class
      ]);
    }
  
    if (null !== $phpTypeName) {
      static::$phpNamesMap[$name] = $phpTypeName;
    }
    
    static::$typesMap[$name] = $class;
  }
  
  /**
   * @return string
   */
  public function __toString()
  {
    return $this->getName();
  }
  
  /**
   * @param $value
   * @return mixed
   */
  abstract public function toPhpValue($value);
  
  /**
   * @param $value
   * @return mixed
   */
  abstract public function toPlatformValue($value);
  
  /**
   * @return string
   */
  abstract public function getName();
  
}