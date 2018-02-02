<?php

namespace Colibri\ServiceContainer;

use Colibri\Collection\Collection;
use Colibri\Common\Configuration;
use Colibri\Connection\ConnectionManager;
use Colibri\Connection\ConnectionManagerInterface;
use Colibri\Core\ClassManager;
use Colibri\Core\EntityManager;
use Colibri\Core\EntityStateManager;
use Colibri\Core\MetadataManager;
use Colibri\Core\RepositoryManager;
use Colibri\Core\State\StateManagerInterface;
use Colibri\EventDispatcher\Dispatcher;
use Colibri\Logger\Handler\Mask\LogLevelMask;
use Colibri\Logger\Log;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;

/**
 * Class Container
 * @package Colibri\ServiceContainer
 */
final class ServiceLocator implements ServiceLocatorInterface, LoggerAwareInterface
{

  /**
   * @var Collection
   */
  protected $instances = null;

  /**
   * Container constructor.
   */
  private function __construct()
  {
    $this->instances = new Collection();
  }

  /**
   * @return ServiceLocatorInterface
   */
  public static function instance()
  {
    static $instance = null;

    if (null === $instance) {
      $instance = new ServiceLocator();
    }

    return $instance;
  }

  /**
   * @param string $name
   * @param object $service
   * @return void
   */
  public function set($name, $service)
  {
    $this->instances->set($name, $service);
  }

  /**
   * @param string $name
   * @return mixed
   */
  public function get($name)
  {
    return $this->instances->get($name);
  }

  /**
   * @return ClassManager
   */
  public function getClassManager()
  {
    if(!$this->instances->has('classManager')) {
      $this->instances->set('classManager', new ClassManager());
    }

    return $this->get('classManager');
  }

  /**
   * @return MetadataManager
   */
  public function getMetadataManager()
  {
    if(!$this->instances->has('metadataManager')) {
      $configuration = $this->getConfiguration();
      $rootDirectory = dirname($configuration['identity']);
      $metadata = sprintf('%s/%s/%s', $rootDirectory, $configuration['build']['build_path'], $configuration['build']['metadata_file']);

      $this->instances->set('metadataManager', new MetadataManager($metadata, $this));
    }

    return $this->get('metadataManager');
  }

  /**
   * @return RepositoryManager
   */
  public function getRepositoryManager()
  {
    if(!$this->instances->has('repositoryManager')) {
      $this->instances->set('repositoryManager', new RepositoryManager($this));
    }

    return $this->get('repositoryManager');
  }
  
  /**
   * @return StateManagerInterface|EntityStateManager
   */
  public function getEntityStateManager()
  {
    if(!$this->instances->has('entityStateManager')) {
      $this->instances->set('entityStateManager', new EntityStateManager());
    }
  
    return $this->get('entityStateManager');
  }
  
  /**
   * @return EntityManager
   */
  public function getEntityManager()
  {
    if(!$this->instances->has('entityManager')) {
      $this->instances->set('entityManager', new EntityManager($this));
    }
    
    return $this->get('entityManager');
  }
  
  /**
   * @return Configuration
   */
  public function getConfiguration()
  {
    return $this->instances->get('configuration');
  }

  /**
   * Sets a logger instance on the object.
   *
   * @param LoggerInterface $logger
   *
   * @return ServiceLocatorInterface
   */
  public function setLogger(LoggerInterface $logger)
  {
    $this->set('logger', $logger);

    return $this;
  }

  /**
   * @return LoggerInterface
   */
  public function getLogger()
  {
    if (!$this->instances->has('logger')) {
      $this->setLogger(new Log('COLIBRI.ORM'));
    }

    return null;
  }

  /**
   * @return Dispatcher
   */
  public function getDispatcher()
  {
    if(!$this->instances->has('dispatcher')) {
      $this->instances->set('dispatcher', new Dispatcher());
    }

    return $this->get('dispatcher');
  }

  /**
   * @return ConnectionManagerInterface
   */
  public function getConnectionManager()
  {
    /** @var Configuration $configuration */
    $configuration = $this->get('configuration');

    if(!$this->instances->has('connectionManager')) {
      $this->set('connectionManager', new ConnectionManager($configuration['connection']));
    }

    return $this->get('connectionManager');
  }

  /**
   * @param null|string $connectionName
   * @return \Colibri\Connection\ConnectionInterface
   */
  public function getConnection($connectionName = null)
  {
    /** @var Configuration $configuration */
    $configuration = $this->get('configuration');
    $connectionName = null !== $connectionName ?: $configuration['connection_name'];

    return $this->getConnectionManager()->getConnection($connectionName);
  }

}