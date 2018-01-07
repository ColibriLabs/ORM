<?php

namespace Colibri\Common;

use Colibri\Exception\BadArgumentException;

/**
 * Class ObjectIdentity
 * @package Colibri\Common
 */
final class ObjectIdentity
{

  /**
   * @var string
   */
  private $identifier = null;

  /**
   * ObjectIdentity constructor.
   * @param string $identifier
   */
  public function __construct($identifier = null)
  {
    $this->identifier = $identifier;
  }

  /**
   * @param ObjectIdentity $objectIdentity
   * @return bool
   */
  public function equals(ObjectIdentity $objectIdentity)
  {
    return $this->getIdentifier() === $objectIdentity->getIdentifier();
  }

  /**
   * @return string
   */
  public function getIdentifier()
  {
    return $this->identifier;
  }

  /**
   * @param $object
   * @return static
   * @throws BadArgumentException
   */
  public static function createFromObject($object)
  {
    static::validateObject($object);

    if ($object instanceof ObjectIdentity) {
      return new static($object->getIdentifier());
    }

    $identifier = sprintf('%s@%s', get_class($object), static::getObjectHash($object, 'sha256'));

    return new static($identifier);
  }

  /**
   * @param $object
   * @param null $hashMethod
   * @return string
   */
  public static function getObjectHash($object, $hashMethod = null)
  {
    return $hashMethod === null ? spl_object_hash($object) : hash($hashMethod, spl_object_hash($object));
  }

  /**
   * @param $object
   * @return bool
   * @throws BadArgumentException
   */
  private static function validateObject($object)
  {
    if (!is_object($object)) {
      throw new BadArgumentException('Object identifier takes only the object but ":type" given', ['type' => gettype($object)]);
    }

    return true;
  }

}
