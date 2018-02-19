<?php

namespace Colibri\Logger\Formatter;

use Colibri\Logger\Collection\Collection;

/**
 * Class AbstractFormatter
 * @package Colibri\Logger\Formatter
 */
abstract class AbstractFormatter implements FormatterInterface
{

  /**
   * @var string
   */
  protected $placeholder = self::PLACEHOLDER_MASK_DOUBLE_DOT;

  /**
   * @var string
   */
  protected $format = '[:datetime] [:level] :message';

  /**
   * @param $string
   * @param array $placeholders
   * @return string
   */
  public function replace($string, array $placeholders = [])
  {
    $replacements = [];

    foreach ($placeholders as $name => $value) {
      $replacements[sprintf($this->placeholder, $name)] = $value;
    }

    return strtr($string, $replacements);
  }

  /**
   * @return string
   */
  public function getPlaceholderType()
  {
    return $this->placeholder;
  }

  /**
   * @param string $placeholder
   * @return $this
   */
  public function setPlaceholderType($placeholder)
  {
    $this->placeholder = $placeholder;

    return $this;
  }

  /**
   * @return string
   */
  public function getFormat()
  {
    return $this->format;
  }

  /**
   * @param string $format
   * @return $this
   */
  public function setFormat($format)
  {
    $this->format = $format;

    return $this;
  }

  /**
   * @param Collection $record
   * @return array
   */
  protected function prepare(Collection $record)
  {
    $placeholders = $record->toArray();
    
    $message = $placeholders['message'];
    unset($placeholders['message']);

    $content = $message['content'];
    $context = $placeholders + $message['context'];
  
    $flattened = [];
    $this->flatten($context, [], $flattened);
    
    $message = $this->replace($content, $flattened);

    $placeholders['message'] = $message;

    return $placeholders;
  }
  
  /**
   * @param array $input
   * @param array $keys
   * @param array $output
   * @return array
   */
  protected function flatten(array $input, array $keys = [], array &$output)
  {
    foreach ($input as $index => $placeholder) {
      
      $key    = array_merge($keys, [$index]);
      $dotted = implode('.', array_merge($keys, [$index]));
      
      if (is_array($placeholder)) {
        $this->flatten($placeholder, $key, $output);
      } else {
        $output[$dotted] = $placeholder;
      }
    }
  }

}
