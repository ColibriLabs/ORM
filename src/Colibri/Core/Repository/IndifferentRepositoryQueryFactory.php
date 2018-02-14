<?php

namespace Colibri\Core\Repository;

use Colibri\Query\Builder;
use Colibri\Query\Statement\Modifiers;

/**
 * Class SoftRepositoryQueryFactory
 * @package Colibri\Core\Repository
 */
class IndifferentRepositoryQueryFactory extends AbstractRepositoryQueryFactory
{
  
  /**
   * @return Builder\Insert
   */
  public function createInsertQuery()
  {
    return parent::createInsertQuery()->addModifier(Modifiers::IGNORE);
  }
  
  /**
   * @return Builder\Update
   */
  public function createUpdateQuery()
  {
    return parent::createUpdateQuery()->addModifier(Modifiers::IGNORE);
  }
  
}