<?php

namespace Colibri\Generator\Helper;

use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

/**
 * Class Console
 * @package Colibri\Generator\Helper
 */
class Console
{
    
    /**
     * @var InputInterface
     */
    protected $input;
    
    /**
     * @var OutputInterface
     */
    protected $output;
    
    /**
     * @var QuestionHelper
     */
    protected $question;
    
    /**
     * Console constructor.
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     */
    public function __construct(InputInterface $input, OutputInterface $output)
    {
        $this->input = $input;
        $this->output = $output;
        $this->question = new QuestionHelper();
    }
    
    /**
     * @param      $message
     * @param null $default
     *
     * @return string
     */
    public function askQuestion($message, $default = null)
    {
        $question = new Question($this->formatMessage($message, $default), $default);
        
        return $this->question->ask($this->input, $this->output, $question);
    }
    
    /**
     * @param      $message
     * @param null $default
     *
     * @return string
     */
    protected function formatMessage($message, $default = null)
    {
        return null === $default
            ? sprintf('<info>%s:</info>', $message)
            : sprintf('<info>%s:</info> [<comment>%s</comment>]', $message, $default);
    }
    
}