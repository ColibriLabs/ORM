<?php

namespace Colibri\Logger\Formatter;

use Colibri\Logger\Collection\Collection;

/**
 * Class LineFormatter
 * @package Colibri\Logger\Formatter
 */
class LineFormatter extends AbstractFormatter
{
    
    /**
     * LineFormatter constructor.
     *
     * @param null $format
     */
    public function __construct($format = null)
    {
        if (null !== $format) {
            $this->setFormat($format);
        }
    }
    
    /**
     * @param Collection $replacement
     *
     * @return string
     */
    public function format(Collection $replacement)
    {
        $replacement = $this->prepare($replacement);
        $messageLines = explode(PHP_EOL, $replacement['message']);
        
        foreach ($messageLines as &$messageLine) {
            $replacement['message'] = $messageLine;
            $messageLine = $this->replace($this->getFormat(), $replacement);
        }
        
        return implode(PHP_EOL, $messageLines);
    }
    
}
