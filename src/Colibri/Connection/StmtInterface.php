<?php

namespace Colibri\Connection;

/**
 * Interface StmtInterface
 * @package Colibri\Connection
 */
interface StmtInterface
{
    
    /**
     * @param null $param
     * @param null $value
     * @param null $type
     * @param null $maxLength
     * @param null $driverData
     *
     * @return mixed
     */
    public function bindParam($param = null, & $value = null, $type = null, $maxLength = null, $driverData = null);
    
    /**
     * @param array $params
     *
     * @return mixed
     */
    public function bindParams(array $params = []);
    
    /**
     * @param array $params
     *
     * @return mixed
     */
    public function execute($params = nu);
    
    /**
     * @param int $dataType
     *
     * @return mixed
     */
    public function fetch($dataType = Connection::FETCH_ASSOC);
    
    /**
     * @return mixed
     */
    public function loadArray();
    
    /**
     * @return mixed
     */
    public function loadNum();
    
    /**
     * @return mixed
     */
    public function loadObject();
    
    /**
     * @param $class
     *
     * @return mixed
     */
    public function loadWithClass($class = \stdClass::class);
    
    /**
     * @param $target
     *
     * @return mixed
     */
    public function loadIntoObject($target);
    
}
