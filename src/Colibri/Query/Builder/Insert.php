<?php

namespace Colibri\Query\Builder;

use Colibri\Collection\Collection;
use Colibri\Connection\ConnectionInterface;
use Colibri\Query\Builder;
use Colibri\Query\Expr;
use Colibri\Query\Statement\Modifiers;
use Colibri\Query\Statement\ValuesSet;

/**
 * Class Insert
 * @package Colibri\Query\Builder
 */
class Insert extends Builder
{
    
    const TEMPLATE = "INSERT%s\nINTO%s\n%s";
    
    use Syntax\ValuesSetTrait;
    use Syntax\ModifiersTrait;
    
    /**
     * Insert constructor.
     *
     * @param ConnectionInterface $connection
     */
    public function __construct(ConnectionInterface $connection)
    {
        parent::__construct($connection);
        
        $this->statements = new Collection([
            'valuesSet' => new ValuesSet($this),
            'modifiers' => new Modifiers($this, Modifiers::MAP_INSERT),
        ]);
    }
    
    /**
     * @param $table
     *
     * @return $this
     */
    public function setTableInto($table)
    {
        return $this->table($table);
    }
    
    /**
     * @return string
     */
    public function toSQL()
    {
        /** @var Expr\Table $table */
        $table = $this->normalizeExpression($this->table);
        
        return sprintf(
            static::TEMPLATE,
            $this->getModifiersStatement()->toSQL(),
            sprintf(' %s ', $table),
            $this->getValuesSetStatement()->toSQL()
        );
    }
    
    /**
     * @return Modifiers
     */
    public function getModifiersStatement()
    {
        return $this->statements['modifiers'];
    }
    
    /**
     * @return ValuesSet
     */
    public function getValuesSetStatement()
    {
        return $this->statements['valuesSet'];
    }
    
}
