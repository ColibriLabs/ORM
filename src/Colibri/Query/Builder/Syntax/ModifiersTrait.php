<?php

namespace Colibri\Query\Builder\Syntax;

use Colibri\Exception\BadArgumentException;
use Colibri\Query\Statement\Modifiers;

/**
 * Class ModifiersTrait
 * @package Colibri\Query\Builder\Syntax
 */
trait ModifiersTrait
{
  /**
   * @return Modifiers
   * @throws BadArgumentException
   */
  abstract public function getModifiersStatement();

  /**
   * @param $modifier
   * @return $this
   */
  public function modifier($modifier)
  {
    return $this->addModifier($modifier);
  }

  /**
   * @param $modifier
   * @return $this
   */
  public function setModifier($modifier)
  {
    $this->getModifiersStatement()->set($modifier);

    return $this;
  }

  /**
   * @param $modifier
   * @return $this
   */
  public function addModifier($modifier)
  {
    $this->getModifiersStatement()->add($modifier);

    return $this;
  }

  /**
   * @param $modifier
   * @return $this
   */
  public function removeModifier($modifier)
  {
    $this->getModifiersStatement()->remove($modifier);

    return $this;
  }

  /**
   * @param bool $remove
   * @return $this
   */
  public function ignore($remove = false)
  {
    return (true === $remove ? $this->removeModifier(Modifiers::IGNORE) : $this->addModifier(Modifiers::IGNORE));
  }

  /**
   * @return $this
   */
  public function delayed()
  {
    return $this->addModifier(Modifiers::DELAYED);
  }

  /**
   * @return $this
   */
  public function distinct()
  {
    return $this->addModifier(Modifiers::DISTINCT);
  }

  /**
   * @return $this
   */
  public function lowPriority()
  {
    return $this->removeModifier(Modifiers::HIGH_PRIORITY)->addModifier(Modifiers::LOW_PRIORITY);
  }

  /**
   * @return $this
   */
  public function highPriority()
  {
    return $this->removeModifier(Modifiers::LOW_PRIORITY)->addModifier(Modifiers::HIGH_PRIORITY);
  }

  /**
   * @return $this
   */
  public function sqlSmallResult()
  {
    return $this->removeModifier(Modifiers::SQL_BIG_RESULT | Modifiers::SQL_BUFFER_RESULT)
      ->addModifier(Modifiers::SQL_SMALL_RESULT);
  }

  /**
   * @return $this
   */
  public function sqlBigResult()
  {
    return $this->removeModifier(Modifiers::SQL_SMALL_RESULT | Modifiers::SQL_BUFFER_RESULT)
      ->addModifier(Modifiers::SQL_BIG_RESULT);
  }

  /**
   * @return $this
   */
  public function sqlBufferResult()
  {
    return $this->removeModifier(Modifiers::SQL_SMALL_RESULT | Modifiers::SQL_BIG_RESULT)
      ->addModifier(Modifiers::SQL_BUFFER_RESULT);
  }

  /**
   * @return $this
   */
  public function sqlCache()
  {
    return $this->removeModifier(Modifiers::SQL_NO_CACHE)->addModifier(Modifiers::SQL_CACHE);
  }

  /**
   * @return $this
   */
  public function sqlNoCache()
  {
    return $this->removeModifier(Modifiers::SQL_CACHE)->addModifier(Modifiers::SQL_NO_CACHE);
  }

  /**
   * @return $this
   */
  public function calculateFoundRows()
  {
    return $this->addModifier(Modifiers::SQL_CALC_FOUND_ROWS);
  }

}