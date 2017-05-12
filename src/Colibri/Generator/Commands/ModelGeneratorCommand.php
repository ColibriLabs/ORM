<?php

namespace Colibri\Generator\Commands;

use Colibri\Generator\Builder\EntityBuilder;
use Colibri\Schema\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ModelGeneratorCommand extends AbstractCommand
{

  /**
   * Configures the current command.
   */
  protected function configure()
  {
    parent::configure();

    $this
      ->addArgument('name', InputArgument::REQUIRED, 'The name of table for which will be generated model')
      ->setName('app:model')->setAliases(['model'])
      ->setDescription('Generate one model for one table')
    ;
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

    $output->writeln('<comment>Start build application</comment>');
    $builder->generateMetadata();
    $entityName = $input->getArgument('name');

    $tables = $builder->getSchema()->getTables()->filter(function(Table $table) use ($entityName) {
      return $entityName === $table->getTableName();
    });

    if($tables->count() == 1) {
      $builder->generateOneModel($tables->getIterator()->current());
    } else {
      $output->writeln(sprintf('<error>Table "%s" was not found in your schema file</error>', $entityName));
    }
  }

}