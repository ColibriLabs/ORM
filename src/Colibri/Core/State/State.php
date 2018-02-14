<?php

namespace Colibri\Core\State;

use Colibri\Common\StringableInterface;

/**
 * Class State
 * @package Colibri\Core\State
 */
class State implements StateInterface, StringableInterface
{
  
  const LOCKED    = 'LOCKED';
  const UNLOCKED  = 'UNLOCKED';
  
  /**
   * @var
   */
  private $state;
  
  /**
   * @var StateIdentifierInterface
   */
  private $identifier;
  
  /**
   * @var StateIdentifierInterface
   */
  private $owner;
  
  /**
   * State constructor.
   * @param string $state
   * @param StateIdentifierInterface $identifier
   * @param StateIdentifierInterface $owner
   */
  public function __construct(string $state, StateIdentifierInterface $identifier, StateIdentifierInterface $owner)
  {
    $this->state = $state;
    $this->identifier = $identifier;
    $this->owner = $owner;
  }
  
  /**
   * @return StateIdentifierInterface
   */
  public function getIdentifier(): StateIdentifierInterface
  {
    return $this->identifier;
  }
  
  /**
   * @return StateIdentifierInterface
   */
  public function getOwner(): StateIdentifierInterface
  {
    return $this->owner;
  }
  
  /**
   * @return mixed
   */
  public function getState(): string
  {
    return $this->state;
  }
  
  /**
   * @return string
   */
  public function toString(): string
  {
    return sprintf('Object %s has "%s" state by %s',
      $this->getIdentifier()->getObjectName(), $this->getState(), $this->getOwner()->getObjectName());
  }
  
}