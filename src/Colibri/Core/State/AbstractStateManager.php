<?php

namespace Colibri\Core\State;

use Colibri\Collection\Collection;

/**
 * Class AbstractStateManager
 * @package Colibri\Core\State
 */
abstract class AbstractStateManager implements StateManagerInterface
{
    
    /**
     * @var Collection
     */
    private $collection;
    
    /**
     * AbstractStateManager constructor.
     */
    public function __construct()
    {
        $this->collection = new Collection([], StateInterface::class);
    }
    
    /**
     * @param StateIdentifierInterface $identifier
     *
     * @return StateInterface
     */
    public function getState(StateIdentifierInterface $identifier): StateInterface
    {
        return $this->collection->offsetGet($identifier->getId());
    }
    
    /**
     * @param StateIdentifierInterface $identifier
     *
     * @return bool
     */
    public function hasState(StateIdentifierInterface $identifier): boolean
    {
        return $this->collection->offsetExists($identifier->getId());
    }
    
    /**
     * @param StateInterface $state
     *
     * @return StateManagerInterface
     */
    public function setState(StateInterface $state): StateManagerInterface
    {
        $this->collection->offsetSet($state->getIdentifier()->getId(), $state);
        
        return $this;
    }
    
}