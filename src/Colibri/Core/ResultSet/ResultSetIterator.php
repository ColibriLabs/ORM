<?php

namespace Colibri\Core\ResultSet;

use Colibri\Core\Domain\RepositoryInterface;

/**
 * Class ResultSetIterator
 * @package Colibri\Core\ResultSet
 */
class ResultSetIterator extends ResultSet
{
    
    /**
     * ResultSetIterator constructor.
     *
     * @param RepositoryInterface $repository
     * @param \Iterator           $iterator
     */
    public function __construct(RepositoryInterface $repository, \Iterator $iterator)
    {
        parent::__construct($iterator);
        
        $this->entityRepository = $repository;
        $this->hydrator = $repository->getHydrator();
        $this->reflection = $repository->getEntityClassReflection();
    }
    
}