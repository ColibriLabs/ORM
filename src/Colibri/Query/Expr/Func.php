<?php

namespace Colibri\Query\Expr;

use Colibri\Exception\BadCallMethodException;
use Colibri\Query\Expression;

/**
 * Class Func
 * @package Colibri\Query\Expr
 */
class Func extends Expression
{

  /**
   * Const array
   */
  const FUNCTIONS = [
    // String functions
    'ASCII' => ['parameters_count' => 0],
    'CHAR_LENGTH' => [],
    'CHARACTER_LENGTH' => [],
    'CONCAT' => [],
    'CONCAT_WS' => [],
    'FIELD' => [],
    'FIND_IN_SET' => [],
    'FORMAT' => [],
    'INSERT' => [],
    'INSTR' => [],
    'LCASE' => [],
    'LEFT' => [],
    'LENGTH' => [],
    'LOCATE' => [],
    'LOWER' => [],
    'LPAD' => [],
    'LTRIM' => [],
    'MID' => [],
    'POSITION' => [],
    'REPEAT' => [],
    'REPLACE' => [],
    'REVERSE' => [],
    'RIGHT' => [],
    'RPAD' => [],
    'RTRIM' => [],
    'SPACE' => [],
    'STRCMP' => [],
    'SUBSTR' => [],
    'SUBSTRING' => [],
    'SUBSTRING_INDEX' => [],
    'TRIM' => [],
    'UCASE' => [],
    'UPPER' => [],
    // Numeric/Math Func
    'ABS' => [],
    'ACOS' => [],
    'ASIN' => [],
    'ATAN' => [],
    'ATAN2' => [],
    'AVG' => [],
    'CEIL' => [],
    'CEILING' => [],
    'COS' => [],
    'COT' => [],
    'COUNT' => [],
    'DEGREES' => [],
    'DIV' => [],
    'EXP' => [],
    'FLOOR' => [],
    'GREATEST' => [],
    'LEAST' => [],
    'LN' => [],
    'LOG' => [],
    'LOG10' => [],
    'LOG2' => [],
    'MAX' => [],
    'MIN' => [],
    'MOD' => [],
    'PI' => [],
    'POW' => [],
    'POWER' => [],
    'RADIANS' => [],
    'RAND' => [],
    'ROUND' => [],
    'SIGN' => [],
    'SIN' => [],
    'SQRT' => [],
    'SUM' => [],
    'TAN' => [],
    'TRUNCATE' => [],
    // Date/Time Func
    'ADDDATE' => [],
    'ADDTIME' => [],
    'CURDATE' => [],
    'CURRENT_DATE' => [],
    'CURRENT_TIME' => [],
    'CURRENT_TIMESTAMP' => [],
    'CURTIME' => [],
    'DATE' => [],
    'DATE_ADD' => [],
    'DATE_FORMAT' => [],
    'DATE_SUB' => [],
    'DATEDIFF' => [],
    'DAY' => [],
    'DAYNAME' => [],
    'DAYOFMONTH' => [],
    'DAYOFWEEK' => [],
    'DAYOFYEAR' => [],
    'EXTRACT' => [],
    'FROM_DAYS' => [],
    'HOUR' => [],
    'LAST_DAY' => [],
    'LOCALTIME' => [],
    'LOCALTIMESTAMP' => [],
    'MAKEDATE' => [],
    'MAKETIME' => [],
    'MICROSECOND' => [],
    'MINUTE' => [],
    'MONTH' => [],
    'MONTHNAME' => [],
    'NOW' => [],
    'PERIOD_ADD' => [],
    'PERIOD_DIFF' => [],
    'QUARTER' => [],
    'SEC_TO_TIME' => [],
    'SECOND' => [],
    'STR_TO_DATE' => [],
    'SUBDATE' => [],
    'SUBTIME' => [],
    'SYSDATE' => [],
    'TIME' => [],
    'TIME_FORMAT' => [],
    'TIME_TO_SEC' => [],
    'TIMEDIFF' => [],
    'TIMESTAMP' => [],
    'TO_DAYS' => [],
    'WEEK' => [],
    'WEEKDAY' => [],
    'WEEKOFYEAR' => [],
    'YEAR' => [],
    'YEARWEEK' => [],
    // Advanced Func
    'BIN' => [],
    'BINARY' => [],
    'CASE' => [],
    'CAST' => [],
    'COALESCE' => [],
    'CONNECTION_ID' => [],
    'CONV' => [],
    'CONVERT' => [],
    'CURRENT_USER' => [],
    'DATABASE' => [],
    'IF' => [],
    'IFNULL' => [],
    'ISNULL' => [],
    'LAST_INSERT_ID' => [],
    'NULLIF' => [],
    'SESSION_USER' => [],
    'SYSTEM_USER' => [],
    'USER' => [],
    'VERSION' => [],
    // Encryption/Compression Func
    'ENCRYPT' => [],
    'MD5' => [],
    'OLD_PASSWORD' => [],
    'PASSWORD' => [],
  ];

  /**
   * String
   */
  const TEMPLATE = '%s(%s)';

  /**
   * @var string
   */
  protected $name = null;

  /**
   * @var Column
   */
  protected $columns = null;

  /**
   * @var array
   */
  protected $parameters = [];

  /**
   * Func constructor.
   * @param string $name
   * @param array $parameters
   * @throws BadCallMethodException
   */
  public function __construct($name, array $parameters = [])
  {
    if (!array_key_exists($name, self::FUNCTIONS)) {
      throw new BadCallMethodException('Not available function name ":name"', [
        'name' => $name,
      ]);
    }

    $this->name = $name;
    $this->parameters = $parameters;
  }

  /**
   * @return null|string
   */
  public function format()
  {
    $function = null;

    switch ($this->getName()) {
      default:
        $function = sprintf(static::TEMPLATE, $this->getName(), implode(', ', $this->getParameters()));
        break;
    }

    return $function;
  }

  /**
   * @return string
   */
  public function getName()
  {
    return $this->name;
  }

  /**
   * @param string $name
   */
  public function setName($name)
  {
    $this->name = $name;
  }

  /**
   * @return array
   */
  public function getParameters()
  {
    return $this->parameters;
  }

  /**
   * @param array $parameters
   */
  public function setParameters(array $parameters)
  {
    $this->parameters = $parameters;
  }

  /**
   * @return string
   */
  public function toSQL()
  {
    return $this->format();
  }

  /**
   * @return string
   */
  public function __toString()
  {
    return $this->toSQL();
  }

}