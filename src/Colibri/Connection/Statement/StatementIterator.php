<?php

namespace Colibri\Connection\Statement;

use Colibri\Connection\Connection;
use Colibri\Connection\ConnectionException;
use Colibri\Connection\StmtInterface;

/**
 * Class StatementIterator
 * @package Colibri\Connection\Statement
 */
class StatementIterator implements \Iterator, \Countable
{
    
    /**
     * @var int
     */
    private $key = 0;
    
    /**
     * @var StmtInterface|\PDOStatement
     */
    private $statement;
    
    /**
     * @var int
     */
    private $fetchMode = Connection::FETCH_ASSOC;
    
    /**
     * @var array|null
     */
    private $row;
    
    /**
     * StatementIterator constructor.
     *
     * @param StmtInterface $stmt
     */
    public function __construct(StmtInterface $stmt)
    {
        $this->statement = $stmt;
    }
    
    /**
     * @param int $fetchMode
     *
     * @throws ConnectionException
     */
    public function setFetchMode($fetchMode = Connection::FETCH_ASSOC)
    {
        if (!($fetchMode & (Connection::FETCH_ASSOC | Connection::FETCH_OBJ))) {
            throw new ConnectionException('Invalid fetch mode passed');
        }
        
        $this->fetchMode = $fetchMode;
    }
    
    /**
     * @inheritDoc
     */
    public function current()
    {
        return $this->row;
    }
    
    /**
     * @inheritDoc
     */
    public function next()
    {
        $this->key++;
        $this->row = $this->statement->fetch($this->fetchMode);
    }
    
    /**
     * @inheritDoc
     */
    public function key()
    {
        return $this->key;
    }
    
    /**
     * @inheritDoc
     */
    public function valid()
    {
        return $this->row !== false;
    }
    
    /**
     * @inheritDoc
     */
    public function rewind()
    {
        $this->key = 0;
        $this->row = $this->statement->fetch($this->fetchMode);
    }
    
    /**
     * @return int
     */
    public function count()
    {
        return $this->statement->rowCount();
    }
    
    /**
     * @return StmtInterface|\PDOStatement
     */
    public function getStatement()
    {
        return $this->statement;
    }
    
}