<?php

namespace Colibri\Extension\EventSubscriber;

use Colibri\Core\Entity\EntityInterface;
use Colibri\Core\Event\EntityLifecycleEvent;
use Colibri\Parameters\ParametersCollection;
use Colibri\Filters\FilterInterface;

/**
 * Class DataFilter
 * @package Colibri\Extension\EventSubscriber
 */
class DataFilter extends AbstractDataFilter
{
  
  /**
   * @inheritDoc
   */
  public function getNameNS()
  {
    return 'dataFilter';
  }
  
  /**
   * @param EntityLifecycleEvent $event
   */
  public function beforePersist(EntityLifecycleEvent $event)
  {
    $this->resolveEntities($event, function (EntityInterface $entity, ParametersCollection $parameters) {
      /** @var ParametersCollection $configuration */
      foreach ($parameters as $propertyName => $configuration) {
        if ($entity->hasProperty($propertyName) && $configuration->offsetExists('filters')) {
          $propertyData = $entity->getByProperty($propertyName);
          $propertyData = $this->applyFilters($propertyData, $configuration->offsetGet('filters')->toArray());
          $entity->setByProperty($propertyName, $propertyData);
        }
      }
    });
  }
  
  /**
   * @param $propertyData
   * @param array $filterClasses
   * @return array|int|string
   */
  protected function applyFilters(&$propertyData, array $filterClasses)
  {
    /** @var FilterInterface $filter */
    foreach ($filterClasses as $filterClass => $filterClassArguments) {
      $filter = new $filterClass(...$filterClassArguments);
      $propertyData = $filter->apply($propertyData);
    }
    
    return $propertyData;
  }
  
}