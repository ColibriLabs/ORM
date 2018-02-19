<?php

namespace Colibri\Core\Event;

use Colibri\Core\Domain\RepositoryInterface;
use Colibri\Query\Builder\Select as SelectQuery;

/**
 * Class FinderExecutionEvent
 * @package Colibri\Core\Event
 */
class FinderExecutionEvent extends AbstractEvent
{
  
  /**
   * @var RepositoryInterface
   */
  protected $repository;
  
  /**
   * @var SelectQuery
   */
  protected $selectQuery;
  
  /**
   * FinderExecutionEvent constructor.
   * @param RepositoryInterface $repository
   * @param SelectQuery         $selectQuery
   */
  public function __construct(RepositoryInterface $repository, SelectQuery $selectQuery)
  {
    $this->repository   = $repository;
    $this->selectQuery  = $selectQuery;
  }
  
  /**
   * @return RepositoryInterface
   */
  public function getRepository()
  {
    return $this->repository;
  }
  
  /**
   * @return SelectQuery
   */
  public function getSelectQuery()
  {
    return $this->selectQuery;
  }
  
}