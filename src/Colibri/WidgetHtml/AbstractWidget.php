<?php

namespace Colibri\WidgetHtml;

use Colibri\Collection\ArrayCollection;
use Colibri\Exception\BadArgumentException;
use Colibri\Html\Element\InputElement;
use Colibri\Html\Element\ItalicElement;
use Colibri\Html\Element\SelectElement;
use Colibri\Html\HtmlElement;

/**
 * Class AbstractWidget
 *
 * @package Colibri\WidgetHtml
 */
abstract class AbstractWidget
{

  /**
   * @var string
   */
  protected $nameFormat = '%s';

  /**
   * @var ArrayCollection|HtmlElement[]
   */
  protected $htmlElements;

  /**
   * AbstractWidget constructor.
   */
  public function __construct()
  {
    $this->htmlElements = new ArrayCollection();
  }

  /**
   * @return ArrayCollection|HtmlElement[]
   */
  public function getHtmlElements()
  {
    return $this->htmlElements;
  }

  /**
   * @param $name
   * @return HtmlElement
   */
  public function getHtmlElement($name)
  {
    return $this->htmlElements->get($name, new ItalicElement(sprintf('Element "%s" not found', $name)));
  }

  /**
   * @param             $name
   * @param HtmlElement $element
   * @return $this
   */
  public function setHtmlElements($name, HtmlElement $element)
  {
    $this->htmlElements->set($name, $element);

    return $this;
  }

  /**
   * @param      $name
   * @param null $inputValue
   * @return string
   */
  public function render($name, $inputValue = null)
  {
    $htmlElement = $this->getHtmlElement($name);

    switch (true) {
      case ($htmlElement instanceof InputElement):
        $htmlElement->setAttribute('value', $inputValue);
        break;
      case ($htmlElement instanceof SelectElement):
        $htmlElement->data('selected', $inputValue);
        break;
      default:
    }

    return $htmlElement->render();
  }

  /**
   * @return string
   */
  public function getNameFormat()
  {
    return $this->nameFormat;
  }

  /**
   * @param string $nameFormat
   * @throws BadArgumentException
   */
  public function setNameFormat($nameFormat)
  {
    if (false === strpos($nameFormat, '%s')) {
      throw new BadArgumentException(
        'Format name ":format" for widget is invalid. ' .
        'Shall be compatibility with sprintf function',
        ['format' => $nameFormat]
      );
    }

    $this->nameFormat = $nameFormat;
  }

}
