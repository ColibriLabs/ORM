<?php declare(strict_types=true);

namespace Colibri\Core\State;

/**
 * Interface StateInterface
 * @package Colibri\Core\State
 */
interface StateInterface
{
  
  /**
   * @return StateIdentifierInterface
   */
  public function getIdentifier();
  
  /**
   * @return StateIdentifierInterface
   */
  public function getOwner();
  
}