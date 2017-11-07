<?php

namespace Colibri\Connection;

use Colibri\Common\Configuration;
use Colibri\ServiceContainer\ServiceLocator;
use Colibri\ServiceContainer\ServiceLocatorInterface;

/**
 * Class Connection
 * @package Colibri\Connection
 */
class Connection extends \PDO implements ConnectionInterface
{

  /**
   * @var string
   */
  protected static $sanitizer = '`';

  /**
   * @var int
   */
  protected $affectedRows = 0;

  /**
   * @var ServiceLocatorInterface
   */
  protected $container = null;
  
  /**
   * @var int
   */
  protected $nestedTransactionCount = 0;
  
  /**
   * @var bool
   */
  protected $isUncommitable = false;
  
  /**
   * @var Configuration
   */
  static protected $config = null;

  /**
   * @param Configuration $configuration
   * @throws ConnectionException
   */
  public function __construct(Configuration $configuration)
  {
    $this->container = ServiceLocator::instance();

    $this->setConfig($configuration);

    try {
      @ parent::__construct(
        $configuration->get('dsn'),
        $configuration->get('user'),
        $configuration->get('password'),
        [
          Connection::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
        ]
      );
    } catch (\Exception $e) {
      throw new ConnectionException('Connection error: ":error"', [
        'error' => $e->getMessage(),
      ]);
    }

    $this->setAttribute(Connection::ATTR_ERRMODE, Connection::ERRMODE_EXCEPTION);
    $this->setAttribute(Connection::ATTR_CURSOR, Connection::CURSOR_SCROLL);
    $this->setAttribute(Connection::ATTR_STATEMENT_CLASS, [__NAMESPACE__ . '\Stmt', [$this]]);

//    $this->setAttribute(Connection::MYSQL_ATTR_USE_BUFFERED_QUERY, false);
  }

  /**
   * @return string
   */
  public function getDriverName()
  {
    return $this->getAttribute(Connection::ATTR_DRIVER_NAME);
  }

  /**
   * @param Configuration $config
   * @return $this
   */
  public function setConfig(Configuration $config)
  {
    static::$config = $config;
    
    return $this;
  }

  /**
   * @return Configuration
   */
  public function getConfig()
  {
    return static::$config;
  }

  /**
   * @param null $query
   * @param array $params
   * @return StmtInterface
   */
  public function prepareQuery($query = null, array $params = [])
  {
    /** @var StmtInterface $stmt */
    $stmt = parent::prepare($query);
    
    if (count($params) > 0) {
      $stmt->bindParams($params);
    }
    
    return $stmt;
  }

  /**
   * @param null $query
   * @return ConnectionInterface
   * @throws ConnectionException
   */
  public function execute($query = null)
  {
    try {
      $event = new ConnectionEvent($this, $query);
      $this->container->getDispatcher()->dispatch(ConnectionEvent::ON_QUERY, $event);
      $this->affectedRows = parent::exec($query);
    } catch (\Exception $exception) {
      throw new ConnectionException('Executing query has error: [:code] ":error"', [
        'code' => $exception->getCode(),
        'error' => $exception->getMessage(),
      ]);
    }

    return $this;
  }

  /**
   * @param null $query
   * @return StmtInterface
   * @throws ConnectionException
   */
  public function query($query = null)
  {
    /** @var StmtInterface $result */
    try {
      
      $event = new ConnectionEvent($this, $query);
      $this->container->getDispatcher()->dispatch(ConnectionEvent::ON_QUERY, $event);
      
      $result = parent::query($query);
    } catch (\Exception $exception) {
      throw new ConnectionException(sprintf(
        'Executing SQL Query was failure with error: [%d] (%s)', $exception->getCode(), $exception->getMessage()));
    }
    
    return $result;
  }

  /**
   * @param string $string
   * @return string
   */
  public function quoteIdentifier($string)
  {
    $sanitizer = static::$sanitizer;

    return '`' . strtr($this->clearIdentifier($string), ['.' => "$sanitizer.$sanitizer"]) . '`';
  }

  /**
   * @param string $string
   * @return string
   */
  public function clearIdentifier($string)
  {
    return str_replace(static::$sanitizer, null, $string);
  }

  /**
   * @param mixed $value
   * @param int $type
   * @return string
   */
  public function escape($value, $type = \PDO::PARAM_STR)
  {
    return $this->quote($value, $type);
  }


  /**
   * @return int
   */
  public function affectedRows()
  {
    return $this->affectedRows;
  }

  /**
   * @param null $name
   * @return string
   */
  public function lastInsertId($name = null)
  {
    return parent::lastInsertId($name);
  }

  /**
   * @param $callback
   * @return mixed
   * @throws ConnectionException
   * @throws \Exception
   */
  public function transaction($callback)
  {
    if (!is_callable($callback, false)) {
      throw new ConnectionException('Callback should be either closure or object-method array format');
    }

    $this->start();

    try {
      $result = call_user_func_array($callback, [$this]);
      $this->commit();
      return $result;
    } catch (\Exception $exception) {
      $this->rollback();
      throw $exception;
    }
  }
  
  /**
   * @return boolean
   */
  public function beginTransaction()
  {
    return static::start();
  }

  /**
   * @return boolean
   */
  public function start()
  {
    $response = true;
    
    if ($this->nestedTransactionCount === 0) {
      $this->isUncommitable = false;
      $response = parent::beginTransaction();
    }
    
    $this->nestedTransactionCount++;
  
    return $response;
  }
  
  /**
   * @return bool
   * @throws ConnectionException
   */
  public function commit()
  {
    $response = true;
    
    if ($this->isInTransaction()) {
      if ($this->nestedTransactionCount === 1) {
        
        if ($this->isUncommitable === true) {
          throw new ConnectionException('Cannot commit transaction because a nested was rolled back');
        }
        
        $response = parent::commit();
      }
      $this->nestedTransactionCount--;
    }

    return $response;
  }

  /**
   * @return boolean
   */
  public function rollback()
  {
    $response = true;
    
    if ($this->isInTransaction()) {
      
      if ($this->nestedTransactionCount === 1) {
        $response = parent::rollBack();
      } else {
        $this->isUncommitable = true;
      }
      
      $this->nestedTransactionCount--;
    }

    return $response;
  }
  
  /**
   * @return bool
   */
  public function isInTransaction()
  {
    return ($this->nestedTransactionCount > 0);
  }
  
  /**
   * @return int
   */
  public function getNestedTransactionCount()
  {
    return $this->nestedTransactionCount;
  }
  
  /**
   * @return bool
   */
  public function isUncommitable()
  {
    return $this->isUncommitable;
  }
  
}
