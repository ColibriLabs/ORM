<?php

namespace Colibri\Generator\Parser;

use Colibri\Collection\ArrayCollection;
use Colibri\Common\ArrayableInterface;
use Colibri\Schema\Database;

/**
 * Class DriverAbstract
 * @package Colibri\Generator\Parser
 */
abstract class DriverAbstract implements ArrayableInterface
{

  /**
   * @var Database
   */
  protected $schema;

  /**
   * DriverAbstract constructor.
   */
  public function __construct()
  {
    $this->schema = new Database('');
  }

  public function getSchema()
  {
    return $this->schema;
  }

  /**
   * @return array
   */
  public function toArray()
  {
//    return $this->schema;
  }

}