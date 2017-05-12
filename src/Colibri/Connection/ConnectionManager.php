<?php

namespace Colibri\Connection;

use Colibri\Collection\ArrayCollection;
use Colibri\Common\Configuration;
use Colibri\Exception\BadArgumentException;
use Colibri\ServiceContainer\ServiceLocator;

/**
 * Class ConnectionManager
 * @package Colibri\Connection
 */
class ConnectionManager implements ConnectionManagerInterface
{

  /**
   * @var ArrayCollection
   */
  protected static $connections = null;

  /**
   * @var ArrayCollection
   */
  protected $connectionSettings = null;

  /**
   * ConnectionManager constructor.
   * @param Configuration $connections
   * @throws BadArgumentException
   */
  public function __construct(Configuration $connections)
  {
    static::$connections = new ArrayCollection();
    $this->connectionSettings = new ArrayCollection();

    if ($connections->count() == 0) {
      throw new BadArgumentException('Connections configurations is broken');
    }

    foreach ($connections as $connectionName => $connection) {
      $this->connectionSettings->set($connectionName, $connection);
    }
  }

  /**
   * @param $name
   * @return ConnectionInterface|null
   * @throws BadArgumentException
   */
  public function getConnection($name)
  {
    if (!$this->connectionSettings->has($name)) {
      throw new BadArgumentException('Connection with name ":name" not defined in configuration file ":file"', [
        'name' => $name, 'file' => ServiceLocator::instance()->getConfiguration()->getIdentity()
      ]);
    }

    if (!static::$connections->has($name)) {
      static::$connections->set($name, new Connection($this->connectionSettings->get($name)));
    }

    return static::$connections[$name];
  }

}