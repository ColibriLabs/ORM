<?php

namespace Colibri\Common;

/**
 * Class Inflector
 * @package Colibri\Common
 */
/**
 * Class Inflector
 * @package Colibri\Common
 */
class Inflector
{

  /**
   * @const string
   */
  const SEPARATOR_DASHED = '-';

  /**
   * @const string
   */
  const SEPARATOR_UNDERSCORE = '_';

  /**
   * @param null $string
   * @return string
   */
  public static function classify($string = null)
  {
    return implode('', array_map(function ($word) {
      return ucfirst(strtolower($word));
    }, explode(static::SEPARATOR_UNDERSCORE, static::clear(static::underscore($string)))));
  }

  /**
   * @param null $string
   * @return string
   */
  public static function camelize($string = null)
  {
    return lcfirst(static::classify($string));
  }

  /**
   * @param null $string
   * @return string
   */
  public static function underscore($string = null)
  {
    return implode(static::SEPARATOR_UNDERSCORE, array_map(function ($word) {
      return strtolower($word);
    }, preg_split('/([A-Z]*[^A-Z]+)/', static::clear($string), -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY)));
  }

  /**
   * @param null $string
   * @return string
   */
  public static function constantify($string = null)
  {
    return strtoupper(static::underscore($string));
  }

  /**
   * @param $string
   * @return string
   */
  protected static function clear($string)
  {
    return preg_replace('/[^a-z\d_]+/ui', null, $string);
  }

}
