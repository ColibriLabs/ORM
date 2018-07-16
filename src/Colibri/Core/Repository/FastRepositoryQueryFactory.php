<?php

namespace Colibri\Core\Repository;

use Colibri\Query\Builder;
use Colibri\Query\Statement\Modifiers;

/**
 * Class FastRepositoryQueryFactory
 * @package Colibri\Core\Repository
 */
class FastRepositoryQueryFactory extends AbstractRepositoryQueryFactory
{
    
    /**
     * @return Builder\Insert
     * @throws \Colibri\Exception\NullPointerException
     */
    public function createInsertQuery()
    {
        return parent::createInsertQuery()->addModifier(Modifiers::DELAYED);
    }
    
}