<?php

namespace Colibri\Generator\Commands;

use Colibri\Collection\ArrayCollection;
use Colibri\Common\Configuration;
use Colibri\Generator\Helper\Console;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class AbstractCommand
 * @package Colibri\Generator\Commands
 */
abstract class AbstractCommand extends Command
{

  /**
   * @var ArrayCollection
   */
  protected $answers;

  /**
   * @var Configuration
   */
  protected $configuration;

  /**
   * @var Console
   */
  protected $helper;

  /**
   * @var string
   */
  protected $currentWorkDirectory;

  /**
   * Configures the current command.
   */
  protected function configure()
  {
    $this->answers = new ArrayCollection();
    $this->currentWorkDirectory = getcwd();
  }

  /**
   * Executes the current command.
   * @param InputInterface $input
   * @param OutputInterface $output
   * @return int|null|void
   */
  protected function execute(InputInterface $input, OutputInterface $output)
  {
    $helper = $this->getConsoleHelper($input, $output);

    $output->writeln([]);

    $message = sprintf('Set configuration filepath relative current work directory "<comment>%s</comment>"', $this->currentWorkDirectory);

    $configuration = $helper->askQuestion($message, 'config.yml');
    $configuration = "{$this->currentWorkDirectory}/$configuration";
  
    $configurationFile = new \SplFileInfo($configuration);
    
    if ($configurationFile->getExtension() === 'php') {
      $this->configuration = new Configuration(include_once $configurationFile->getRealPath());
    } else {
      $this->configuration = Configuration::createFromFile($configurationFile->getRealPath());
    }
  }

  /**
   * @param InputInterface $input
   * @param OutputInterface $output
   * @return Console
   */
  protected function getConsoleHelper(InputInterface $input, OutputInterface $output)
  {
    return new Console($input, $output);
  }

  /**
   * @return Configuration
   */
  public function getConfiguration()
  {
    return $this->configuration->get('colibri_orm');
  }

}