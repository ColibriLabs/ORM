<?php

namespace Colibri\Core\Hydrator\MetadataValidator;

use Colibri\Core\Domain\MetadataInterface;
use Colibri\Validator\Validator as BaseValidator;

/**
 * Class Validator
 * @package Colibri\Core\Hydrator\MetadataValidator
 */
class Validator extends BaseValidator
{
  
  /**
   * @var MetadataInterface
   */
  protected $entityMetadata;
  
  /**
   * Validator constructor.
   * @param MetadataInterface $metadata
   */
  public function __construct(MetadataInterface $metadata)
  {
    parent::__construct();
    
    $this->entityMetadata = $metadata;
  }
  
}