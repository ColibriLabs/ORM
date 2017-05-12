<?php

namespace Colibri\Generator\Commands;

use Colibri\Generator\Builder\EntityBuilder;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class BuildApplicationCommand
 * @package Colibri\Generator\Commands
 */
class BuildApplicationCommand extends AbstractCommand
{

  /**
   * Configures the current command.
   */
  protected function configure()
  {
    parent::configure();

    $this->setName('app:build')->setAliases(['build'])
      ->setDescription('Fully build colibri-orm application');
  }

  /**
   * @param InputInterface $input
   * @param OutputInterface $output
   * @return void
   */
  protected function execute(InputInterface $input, OutputInterface $output)
  {
    parent::execute($input, $output);

    $builder = new EntityBuilder($this->getConfiguration(), $output);

    $output->writeln('<info>Start build application!</info>');
    $builder->generateMetadata();
    $output->writeln('<info>Build models from schema file</info>');
    $builder->generateAllModels();
    $output->writeln('<info>Well done! Application was successfully installed!</info>');
  }

}