<?php

namespace Colibri\Connection;

/**
 * Class Stmt
 * @package Colibri\Connection
 */
class Stmt extends \PDOStatement implements StmtInterface
{
    
    /**
     * @var Connection|null
     */
    protected $connection = null;
    
    /**
     * Stmt constructor.
     *
     * @param Connection $connection
     */
    protected function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }
    
    /**
     * @param array $params
     *
     * @return $this
     */
    public function bindParams(array $params = [])
    {
        foreach ($params as $parameter => & $value) {
            $this->bindParam((is_numeric($parameter) ? $parameter + 1 : $parameter), $value, Connection::PARAM_STR);
        }
        
        return $this;
    }
    
    /**
     * @param null $parameter
     * @param null $value
     * @param null $type
     * @param null $maxLength
     * @param null $driverData
     *
     * @return $this
     */
    public function bindParam($parameter = null, & $value = null, $type = null, $maxLength = null, $driverData = null)
    {
        parent::bindParam($parameter, $value, $type);
        
        return $this;
    }
    
    /**
     * @param array $params
     *
     * @return $this
     */
    public function multiBind(array $params = [])
    {
        foreach ($params as $parameter => $value) {
            $this->bindValue((is_numeric($parameter) ? $parameter + 1 : $parameter), $value, Connection::PARAM_STR);
        }
        
        return $this;
    }
    
    /**
     * @param null $parameter
     * @param null $value
     * @param null $type
     *
     * @return $this
     */
    public function bindValue($parameter = null, $value = null, $type = null)
    {
        parent::bindValue($parameter, $value, $type);
        
        return $this;
    }
    
    /**
     * @param array $params
     *
     * @return $this
     */
    public function execute($params = null)
    {
        parent::execute($params);
        
        return $this;
    }
    
    /**
     * @return int
     */
    public function numRows()
    {
        return parent::rowCount();
    }
    
    /**
     * @return mixed
     */
    public function loadArray()
    {
        return $this->fetch(Connection::FETCH_ASSOC);
    }
    
    /**
     * @param null $style
     * @param int  $cursor
     * @param int  $cursorOffset
     *
     * @return mixed
     */
    public function fetch($style = null, $cursor = Connection::FETCH_ORI_NEXT, $cursorOffset = 0)
    {
        return parent::fetch($style, $cursor, $cursorOffset);
    }
    
    /**
     * @return mixed
     */
    public function loadNum()
    {
        return $this->fetch(Connection::FETCH_NUM);
    }
    
    /**
     * @param $class
     *
     * @return mixed
     * @throws ConnectionException
     */
    public function loadWithClass($class = \stdClass::class)
    {
        throw new ConnectionException('[:method] Not implement yet...', [
            'method' => __METHOD__,
        ]);
    }
    
    /**
     * @return mixed
     */
    public function loadColumn()
    {
        return $this->fetch(Connection::FETCH_COLUMN);
    }
    
    /**
     * @param string $target
     *
     * @return null|string
     * @throws ConnectionException
     */
    public function loadIntoObject($target = \stdClass::class)
    {
        if (is_string($target) && class_exists($target)) {
            $object = new $target();
        } elseif (is_object($target)) {
            $object = $target;
        } else {
            throw new ConnectionException('Target object or class ":class" not found', [
                'class' => is_object($target) ? get_class($target) : $target,
            ]);
        }
        
        $row = $this->loadObject();
        if (!$row) return null;
        
        foreach ($row as $key => $value) {
            $object->$key = $value;
        }
        
        return $object;
    }
    
    /**
     * @return mixed
     */
    public function loadObject()
    {
        return $this->fetch(Connection::FETCH_OBJ);
    }
    
}