<?php

namespace Colibri\ServiceContainer;

use Colibri\Common\Configuration;
use Colibri\Connection\ConnectionManagerInterface;
use Colibri\Core\ClassManager;
use Colibri\Core\MetadataManager;
use Colibri\Core\RepositoryManager;
use Colibri\EventDispatcher\Dispatcher;
use Psr\Log\LoggerInterface;

/**
 * Interface ContainerInterface
 * @package Colibri\ServiceContainer
 */
interface ServiceLocatorInterface {

  /**
   * @param string $name
   * @param object $service
   * @return mixed
   */
  public function set($name, $service);

  /**
   * @param string $name
   * @return mixed
   */
  public function get($name);

  /**
   * @return Configuration
   */
  public function getConfiguration();

  /**
   * Sets a logger instance on the object.
   *
   * @param LoggerInterface $logger
   *
   * @return ServiceLocatorInterface
   */
  public function setLogger(LoggerInterface $logger);

  /**
   * @return LoggerInterface
   */
  public function getLogger();

  /**
   * @return Dispatcher
   */
  public function getDispatcher();

  /**
   * @return ClassManager
   */
  public function getClassManager();

  /**
   * @return MetadataManager
   */
  public function getMetadataManager();

  /**
   * @return RepositoryManager
   */
  public function getRepositoryManager();

  /**
   * @return ConnectionManagerInterface
   */
  public function getConnectionManager();

  /**
   * @param null|string $name
   * @return \Colibri\Connection\ConnectionInterface
   */
  public function getConnection($name = null);


}