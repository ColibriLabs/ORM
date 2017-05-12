<?php

namespace Colibri\Common;

use Colibri\Parameters\ParametersCollection;

/**
 * Class Configuration
 * @package Colibri\Common
 */
class Configuration extends ParametersCollection
{
  
  /**
   * @return bool
   */
  public function validateConnection()
  {
    return isset($this['connection'], $this['connection_name']);
  }
  
  /**
   * @return bool
   */
  public function validateIdentity()
  {
    return isset($this['identity']) && file_exists($this['identity']);
  }
  
  /**
   * @return mixed|null
   */
  public function getConnection()
  {
    return $this->validateConnection() ? $this['connection'] : null;
  }
  
  /**
   * @return mixed|null
   */
  public function getConnectionName()
  {
    return $this->validateConnection() ? $this['connection_name'] : null;
  }
  
  /**
   * @return string
   */
  public function getIdentity()
  {
    return $this['identity'];
  }
  
  /**
   * @return string|null
   */
  public function getAdditionalConfigurationDirectory()
  {
    return isset($this['configuration_glob_pattern']) ? $this['configuration_glob_pattern'] : null;
  }
  
}