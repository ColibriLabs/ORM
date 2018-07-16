<?php declare(strict_types=true);

namespace Colibri\Core\State;

/**
 * Interface StateIdentifierInterface
 * @package Colibri\Core\State
 */
interface StateIdentifierInterface
{
    
    /**
     * @return string
     */
    public function getId(): string;
    
    /**
     * @return string
     */
    public function getObjectName(): string;
    
}