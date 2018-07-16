<?php

namespace Colibri\Query\Builder;

use Colibri\Collection\Collection;
use Colibri\Connection\ConnectionInterface;
use Colibri\Exception\BadArgumentException;
use Colibri\Query\Builder;
use Colibri\Query\Expr;
use Colibri\Query\Statement\Limit;
use Colibri\Query\Statement\Modifiers;
use Colibri\Query\Statement\OrderBy;
use Colibri\Query\Statement\Set;
use Colibri\Query\Statement\Where;

/**
 * Class Update
 * @package Colibri\Query\Builder
 */
class Update extends Builder
{
    
    use Syntax\WhereTrait;
    use Syntax\OrderByTrait;
    use Syntax\SetTrait;
    use Syntax\ModifiersTrait;
    use Syntax\LimitTrait;
    
    const TEMPLATE = "UPDATE%s%s%s%s%s%s";
    
    /**
     * Update constructor.
     *
     * @param ConnectionInterface $connection
     */
    public function __construct(ConnectionInterface $connection)
    {
        parent::__construct($connection);
        
        $this->statements = new Collection([
            'modifiers' => new Modifiers($this, Modifiers::MAP_UPDATE),
            'set'       => new Set($this),
            'where'     => new Where($this),
            'order'     => new OrderBy($this),
            'limit'     => new Limit($this),
        ]);
    }
    
    /**
     * @return string
     */
    public function toSQL()
    {
        $statementsNames = [
            'set'   => "\nSET %s",
            'where' => "\nWHERE %s",
            'order' => "\nORDER BY %s",
            'limit' => "\nLIMIT %s",
        ];
        
        /** @var Expr\Table $table */
        $table = $this->normalizeExpression($this->table);
        
        $statements = [];
        $statements[] = (null === ($modifiers = $this->getModifiersStatement()->toSQL())) ? null : $modifiers;
        $statements[] = "\n$table";
        
        foreach ($statementsNames as $name => $template) {
            if (null !== ($statement = $this->statements[$name]) && null !== ($statementSQL = $statement->toSQL())) {
                $statements[] = sprintf($template, $statementSQL);
            } else {
                $statements[] = null;
            }
        }
        
        return sprintf(static::TEMPLATE, ...$statements);
    }
    
    /**
     * @return Modifiers
     */
    public function getModifiersStatement()
    {
        return $this->statements->offsetGet('modifiers');
    }
    
    /**
     * @return Where
     * @throws BadArgumentException
     */
    public function getWhereStatement()
    {
        return $this->statements->offsetGet('where');
    }
    
    /**
     * @return OrderBy
     * @throws BadArgumentException
     */
    public function getOrderByStatement()
    {
        return $this->statements->offsetGet('order');
    }
    
    /**
     * @return Limit
     */
    public function getLimitStatement()
    {
        return $this->statements->offsetGet('limit');
    }
    
    /**
     * @return Set
     */
    public function getSetStatement()
    {
        return $this->statements->offsetGet('set');
    }
    
}