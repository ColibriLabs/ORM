<?php

namespace Colibri\Generator\Builder;

use Colibri\Common\Configuration;
use Colibri\Exception\RuntimeException;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class Builder
 * @package Colibri\Generator\Builder
 */
abstract class Builder
{
    const ENTITY_TEMPLATE            = '%s';
    const ENTITY_REPOSITORY_TEMPLATE = '%sRepository';
    
    const BASE_ENTITY_TEMPLATE            = 'Base%s';
    const BASE_ENTITY_REPOSITORY_TEMPLATE = 'Base%sRepository';
    
    /**
     * @var Configuration
     */
    protected $configuration;
    
    /**
     * @var OutputInterface
     */
    protected $output;
    
    /**
     * @var string
     */
    protected $buildDirectory;
    
    /**
     * @var \SplFileObject
     */
    protected $schemaFile;
    
    /**
     * Builder constructor.
     *
     * @param Configuration   $configuration
     * @param OutputInterface $output
     */
    public function __construct(Configuration $configuration, OutputInterface $output)
    {
        $this->configuration = $configuration;
        $this->output = $output;
        $this->configure();
    }
    
    /**
     * @return void
     */
    protected function configure()
    {
        $directory = dirname($this->getConfiguration()->path('identity'));
        
        $buildDirectory = "{$directory}/{$this->getConfiguration()->path('build.build_path')}";
        
        $this->createDirectory($buildDirectory);
        
        $this->buildDirectory = realpath($buildDirectory);
        $this->schemaFile = new \SplFileObject("{$directory}/{$this->getConfiguration()->path('schema_file')}");
        
        if ($this->buildDirectory === false) {
            $this->writeConsole('Build directory was founded');
        }
    }
    
    /**
     * @return Configuration
     */
    public function getConfiguration()
    {
        return $this->configuration;
    }
    
    /**
     * @param $directory
     *
     * @return $this
     * @throws RuntimeException
     */
    protected function createDirectory($directory)
    {
        $isCreated = file_exists($directory) || is_dir($directory) || mkdir($directory, 0777, true);
        
        if (!$isCreated)
            throw new RuntimeException('Cannot create directory ":dir" for generated classed', ['dir' => $directory]);
        
        return $this;
    }
    
    /**
     * @param $message
     *
     * @return $this
     */
    protected function writeConsole($message)
    {
        $this->output->writeln($message);
        
        return $this;
    }
    
    /**
     * @return string
     */
    public function getBuildBaseDirectory()
    {
        return sprintf('%s/Base', $this->buildDirectory);
    }
    
    /**
     * @return \SplFileObject
     */
    public function getSchemaFile()
    {
        return $this->schemaFile;
    }
    
    /**
     * @param      $name
     * @param      $script
     * @param bool $rewrite
     *
     * @return $this
     */
    protected function createClassFile($name, $script, $rewrite = true)
    {
        $name = str_replace('\\', DIRECTORY_SEPARATOR, $name);
        $classPath = "{$this->getBuildDirectory()}/$name.php";
        
        return $this->createFile($classPath, $script, $rewrite);
    }
    
    /**
     * @return string
     */
    public function getBuildDirectory()
    {
        return $this->buildDirectory;
    }
    
    /**
     * @param      $filepath
     * @param      $script
     * @param bool $rewrite
     *
     * @return $this
     */
    public function createFile($filepath, $script, $rewrite = true)
    {
        $this->createDirectory(dirname($filepath));
        
        if (!file_exists($filepath) || $rewrite === true) {
            file_put_contents($filepath, $script);
        }
        
        return $this;
    }
    
}