<?php

namespace Colibri\Schema;

use Colibri\Collection\Collection;
use Colibri\Common\ArrayableInterface;
use Colibri\Common\Inflector;

/**
 * Class Database
 * @package Colibri\Schema
 */
class Database implements ArrayableInterface
{

  /**
   * @var Platform
   */
  protected $platform;

  /**
   * @var string
   */
  protected $package;

  /**
   * @var string
   */
  protected $name;

  /**
   * @var Collection|Table[]
   */
  protected $tables;

  /**
   * Database constructor.
   * @param $name
   */
  public function __construct($name)
  {
    $this->name = $name;
    $this->tables = new Collection();
  }

  /**
   * @return Platform
   */
  public function getPlatform()
  {
    return $this->platform;
  }

  /**
   * @param Platform $platform
   */
  public function setPlatform(Platform $platform)
  {
    $this->platform = $platform;
  }

  /**
   * @return mixed
   */
  public function getPackage()
  {
    return $this->package;
  }

  /**
   * @param mixed $package
   * @return $this
   */
  public function setPackage($package)
  {
    $this->package = implode('\\', array_map(function($piece) {
      return Inflector::classify(Inflector::underscore($piece));
    }, explode('.', $package)));

    return $this;
  }

  /**
   * @return Collection|Table[]
   */
  public function getTables()
  {
    return $this->tables;
  }

  /**
   * @param $name
   * @return Table|null
   */
  public function getTable($name)
  {
    return $this->tables->has($name) ? $this->tables[$name] : null;
  }

  /**
   * @param Table $table
   * @return $this
   */
  public function addTable(Table $table)
  {
    $this->tables->set($table->getTableName(), $table);

    return $this;
  }

  /**
   * @param $name
   * @return $this
   */
  public function removeTable($name)
  {
    $this->tables->remove($name);

    return $this;
  }

  /**
   * @return mixed
   */
  public function getName()
  {
    return $this->name;
  }

  /**
   * @param mixed $name
   * @return $this
   */
  public function setName($name)
  {
    $this->name = $name;

    return $this;
  }

  /**
   * @return array
   */
  public function toArray()
  {
    $tables = [];
    $this->tables->each(function (Table $table) use (&$tables) {
      $tables[$table->getTableName()] = $table->toArray();
    });

    return [
      'name' => $this->getName(),
      'tables' => $tables,
    ];
  }

}