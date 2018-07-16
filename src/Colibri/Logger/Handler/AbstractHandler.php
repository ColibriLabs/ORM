<?php

namespace Colibri\Logger\Handler;

use Colibri\Logger\Formatter\FormatterInterface;
use Colibri\Logger\Formatter\LineFormatter;
use Colibri\Logger\Handler\Mask\LogLevelMask;

/**
 * Class AbstractHandler
 * @package Colibri\Logger\Handler
 */
abstract class AbstractHandler implements HandlerInterface
{
    
    /**
     * @var LogLevelMask
     */
    protected $level = null;
    
    /**
     * @var FormatterInterface
     */
    protected $formatter = null;
    
    /**
     * AbstractHandler constructor.
     *
     * @param $level
     */
    public function __construct($level)
    {
        $this->formatter = new LineFormatter();
        $this->level = new LogLevelMask($level);
    }
    
    /**
     * @return FormatterInterface
     */
    public function getFormatter()
    {
        return $this->formatter;
    }
    
    /**
     * @param FormatterInterface $formatter
     */
    public function setFormatter(FormatterInterface $formatter)
    {
        $this->formatter = $formatter;
    }
    
    /**
     * @param $level
     *
     * @return boolean
     */
    public function levelAllow($level)
    {
        return $this->level->has($level);
    }
    
    
}