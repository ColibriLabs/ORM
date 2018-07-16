<?php declare(strict_types=true);

namespace Colibri\Core\State;

/**
 * Interface StateManagerInterface
 * @package Colibri\Core\State
 */
interface StateManagerInterface
{
    
    /**
     * @param StateIdentifierInterface $identifier
     *
     * @return mixed
     */
    public function getState(StateIdentifierInterface $identifier): StateInterface;
    
    /**
     * @param StateIdentifierInterface $identifier
     *
     * @return mixed
     */
    public function hasState(StateIdentifierInterface $identifier): boolean;
    
    /**
     * @param StateInterface $state
     *
     * @return mixed
     */
    public function setState(StateInterface $state): StateManagerInterface;
    
}