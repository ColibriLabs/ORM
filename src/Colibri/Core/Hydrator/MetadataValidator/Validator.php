<?php

namespace Colibri\Core\Hydrator\MetadataValidator;

use Colibri\Core\Domain\EntityInterface;
use Colibri\Core\Domain\MetadataInterface;
use Colibri\Validator\ValidableInterface;
use Colibri\Validator\Validator as BaseValidator;
use Colibri\Validator\ValidatorException;

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
     *
     * @param MetadataInterface $metadata
     */
    public function __construct(MetadataInterface $metadata)
    {
        parent::__construct();
        
        $this->entityMetadata = $metadata;
    }
    
    /**
     * @param mixed $value
     *
     * @return ValidableInterface
     * @throws ValidatorException
     */
    public function with($value): ValidableInterface
    {
        parent::with($value);
        
        if (false === ($value instanceof EntityInterface)) {
            throw new ValidatorException(sprintf('Validator accept only (%s) objects', EntityInterface::class));
        }
        
        return $this;
    }
    
    /**
     * @throws ValidatorException
     * @return Validator
     */
    public function setupRules()
    {
        $metadata = $this->getEntityMetadata();
        
        /*if ($this->with instanceof EntityInterface) {
          foreach ($metadata->getNames() as $name) {
          
          }
        }*/
        
        throw new ValidatorException(sprintf('Tatget entity do not specified yet. Call %s::with() before', __CLASS__));
    }
    
    /**
     * @return MetadataInterface
     */
    public function getEntityMetadata(): MetadataInterface
    {
        return $this->entityMetadata;
    }
    
}