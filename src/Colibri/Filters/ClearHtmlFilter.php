<?php

namespace Colibri\Filters;

/**
 * Class ClearHtmlFilter
 * @package Colibri\Filters
 */
class ClearHtmlFilter extends AbstractFilter
{
  
  /**
   * @var array
   */
  protected $allowedTags = [
    'html', 'body',
    'b', 'br', 'hr', 'i', 'li', 'ol', 'p', 's',
    'span', 'table', 'tr', 'td',
    'u', 'ul'
  ];
  
  /**
   * ClearHtmlFilter constructor.
   * @param $allowedTags
   */
  public function __construct(array $allowedTags = null)
  {
    if (null !== $allowedTags && is_array($allowedTags)) {
      $this->setAllowedTags($allowedTags);
    }
  }
  
  /**
   * @inheritDoc
   */
  public function apply($input)
  {
    $allowedTags = array_map(function ($allowedTag) {
      return sprintf('<%s>', $allowedTag);
    }, $this->getAllowedTags());

    return strip_tags($input, implode($allowedTags));
  }
  
  /**
   * @return array
   */
  public function getAllowedTags(): array
  {
    return $this->allowedTags;
  }
  
  /**
   * @param array $allowedTags
   * @return $this
   */
  public function setAllowedTags(array $allowedTags)
  {
    $this->allowedTags = $allowedTags;
    
    return $this;
  }
  
}