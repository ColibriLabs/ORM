<?php

namespace Colibri\Generator\Builder;

use Colibri\Common\Inflector;
use Colibri\Core\Metadata;
use Colibri\Generator\Parser\XmlParser;
use Colibri\Generator\Template\Template;
use Colibri\Schema\Database;
use Colibri\Schema\Field;
use Colibri\Schema\Table;
use Colibri\Schema\Types\EnumType;
use Symfony\Component\Console\Helper\ProgressBar;

/**
 * Class EntityBuilder
 * @package Colibri\Generator\Builder
 */
class EntityBuilder extends Builder
{

  /**
   * @var XmlParser
   */
  protected $parser;

  /**
   * @var string
   */
  protected $namespace;

  /**
   * @var Database
   */
  protected $schema;

  /**
   * @return void
   */
  protected function configure()
  {
    parent::configure();

    $this->parser = new XmlParser(new \SimpleXMLElement(
      file_get_contents($this->getSchemaFile()->getPathname())
    ));

    $this->getParser()->parse();

    $this->schema = $this->getParser()->getSchema();
    $this->namespace = $this->getSchema()->getPackage();
  }

  /**
   * @param Table $table
   * @return $this
   */
  public function generateOneModel(Table $table)
  {
    $this->buildEntityRepository($table, $this->getNamespace());
    $this->buildEntity($table, $this->getNamespace());

    return $this;
  }

  /**
   * @return $this
   */
  public function generateMetadata()
  {
    $this->buildMetadataFile($this->getSchema());
    $this->buildClassLoader($this->getNamespace());

    return $this;
  }

  /**
   * @return $this
   */
  public function generateAllModels()
  {
    $tables = $this->getSchema()->getTables();

    $progress = new ProgressBar($this->output, $tables->count());

    $progress->setFormat("\n%message%\n\n<info>%bar%</info>\n\n");
    $progress->setBarWidth(80);
    $progress->setBarCharacter("▓");
    $progress->setProgressCharacter("▓");
    $progress->setEmptyBarCharacter("░");

    foreach ($tables as $tableName => $table) {
      $this->generateOneModel($table);
      $progress->setMessage(sprintf('<info>Processing table:</info> <comment>%s.%s</comment>', $this->getSchema()->getPackage(), $table->getTableName()));
      $progress->advance();
    }

    $progress->setMessage(sprintf('<info>%d</info> <comment>tables was successfully processed</comment>', $tables->count()));
    $progress->finish();

    return $this;
  }

  /**
   * @param $namespace
   * @return $this
   */
  protected function buildClassLoader($namespace)
  {
    $template = new Template(__DIR__);
    $template->set('namespace', $namespace);

    $script = $template->render('templates/autoload.php');
    $file = "{$this->getBuildDirectory()}/autoload.php";

    $this->createFile($file, $script);

    return $this;
  }

  /**
   * @param Database $databaseNode
   * @return $this
   */
  protected function buildMetadataFile(Database $databaseNode)
  {
    $metadata = [];
    $namespace = $databaseNode->getPackage();
    $template = new Template(__DIR__);

    foreach ($databaseNode->getTables() as $table) {
      $entityClass = sprintf('%s\\%s', $namespace, sprintf(EntityBuilder::ENTITY_TEMPLATE, $table->getClassifyName()));
      $entityMetadata = $this->collectEntityMetadata($table, $namespace);
      $metadata[$entityClass] = $entityMetadata;

      $entityMetadataFile = sprintf("{$this->getBuildDirectory()}/EntityMetadata/%s.php", $table->getClassifyName());
      $entityMetadataScript = sprintf("<?php\n\nreturn %s;", var_export($entityMetadata, true));
      $this->createFile($entityMetadataFile, $entityMetadataScript);
    }

    $template->set('metadata', $metadata);
    $metadataScript = $template->render('templates/metadata.php');
    $metadataFile = "{$this->getBuildDirectory()}/metadata.php";
    $this->createFile($metadataFile, $metadataScript);

    return $this;
  }

  /**
   * @param Table $table
   * @param $package
   */
  protected function buildEntity(Table $table, $package)
  {
    $template = $this->getTemplate($table, $package);
    $template->set('enumeration', $this->getEnumTypedFields($table));
    
    $baseClass = sprintf(static::BASE_ENTITY_TEMPLATE, $table->getClassifyName());
    $commonClass = sprintf(static::ENTITY_TEMPLATE, $table->getClassifyName());

    $sourceScript = $template->render('templates/baseEntity.php');

    $this->createClassFile(sprintf('Base/%s', $baseClass), $sourceScript);
    $script = $this->getCommonClassScript($package, $commonClass, $baseClass);
    $this->createClassFile($commonClass, $script, false);
  }

  /**
   * @param Table $table
   * @param $package
   */
  protected function buildEntityRepository(Table $table, $package)
  {
    $template = $this->getTemplate($table, $package);

    $baseClass = sprintf(static::BASE_ENTITY_REPOSITORY_TEMPLATE, $table->getClassifyName());
    $sourceScript = $template->render('templates/baseEntityRepository.php');

    $this->createClassFile(sprintf('Base/%s', $baseClass), $sourceScript);

    $class = sprintf(static::ENTITY_REPOSITORY_TEMPLATE, $table->getClassifyName());
    $script = $this->getCommonClassScript($package, $class, $baseClass);
    $this->createClassFile($class, $script, false);
  }

  /**
   * @param Table $table
   * @param null $namespace
   * @return array
   */
  protected function collectEntityMetadata(Table $table, $namespace = null)
  {
    $classifyName = $table->getClassifyName();
    $identifier = $this->getIdentityField($table);

    $metadata = [
      Metadata::ENTITY_CLASS => sprintf('%s\\%s', $namespace, sprintf(EntityBuilder::ENTITY_TEMPLATE, $classifyName)),
      Metadata::REPOSITORY_CLASS => sprintf('%s\\%s', $namespace, sprintf(EntityBuilder::ENTITY_REPOSITORY_TEMPLATE, $classifyName)),
      Metadata::TABLE_NAME => $table->getTableName(),
      Metadata::IDENTIFIER => $identifier ? $identifier->getColumn() : null,
      Metadata::RAW_NAMES => [],
      Metadata::NAMES => [],
      Metadata::RELATIONS => [],
      Metadata::ENUMERATIONS => [],
      Metadata::DEFAULT_VALUES => [],
      Metadata::NULLABLE => [],
      Metadata::UNSIGNED => [],
      Metadata::PRIMARY => [],
      Metadata::FIELD_INSTANCES => [],
    ];

    $enumeration = $this->getEnumTypedFields($table)->map(function (Field $field) {
      return [
        'name' => $field->getName(),
        'enumeration' => $field->getType()->getExtra(),
      ];
    })->toArray();

    $defaultValues = $this->getDefaultValuesFields($table)->map(function (Field $field) {
      return [
        'name' => $field->getName(),
        'default' => $field->getDefault(),
      ];
    })->toArray();

    $nullable = $this->getNullableFields($table)->map(function (Field $field) {
      return $field->getName();
    })->toArray();

    $unsigned = $this->getUnsignedFields($table)->map(function (Field $field) {
      return $field->getName();
    })->toArray();

    $primaries = $this->getPrimaryFields($table)->map(function (Field $field) {
      return $field->getName();
    })->toArray();

    $metadata[Metadata::ENUMERATIONS] = array_column($enumeration, 'enumeration', 'name');
    $metadata[Metadata::DEFAULT_VALUES] = array_column($defaultValues, 'default', 'name');
    $metadata[Metadata::NULLABLE] = $nullable;
    $metadata[Metadata::UNSIGNED] = $unsigned;
    $metadata[Metadata::PRIMARY] = $primaries;

    foreach ($table->getFields() as $field) {
      $metadata[Metadata::RAW_NAMES][$field->getName()] = sprintf('%s.%s', $table->getTableName(), $field->getColumn());
      $metadata[Metadata::NAMES][$field->getName()] = $field->getColumn();
      $metadata[Metadata::FIELD_INSTANCES][$field->getName()] = $field;
    }

    if ($table->hasRelation()) {
      foreach ($table->getRelations() as $relation) {

        $relatedTable = $this->getSchema()->getTable($relation->getForeignTable());
        $relatedName = Inflector::classify($relatedTable->getName());

        $metadata[Metadata::RELATIONS][$relation->getLocalField()] = [
          'association_type' => $relation->getAssociationType(),
          'relation_name' => $relation->getRelationName(),
          'local' => $relation->getLocalField(),
          'target' => $relation->getForeignField(),
          'target_entity' => sprintf('%s\\%s', $namespace, sprintf(EntityBuilder::ENTITY_TEMPLATE, $relatedName)),
          'local_entity' => sprintf('%s\\%s', $namespace, sprintf(EntityBuilder::ENTITY_TEMPLATE, $classifyName)),
        ];
      }
    }

    return $metadata;
  }

  /**
   * @param $package
   * @param $class
   * @param $baseClass
   * @return string
   */
  protected function getCommonClassScript($package, $class, $baseClass)
  {
    $phpdocInfo = (new Template(__DIR__))
      ->render('templates/phpdocInfo.php');
    $script = <<<ENTITY_SCRIPT
<?php

$phpdocInfo

namespace $package;

class $class extends Base\\$baseClass
{
  // ... write your custom code here
}
ENTITY_SCRIPT;

    return $script;
  }

  /**
   * @param Table $table
   * @param $package
   * @return Template
   */
  protected function getTemplate(Table $table, $package)
  {
    $template = new Template(__DIR__);

    $template->set('namespace', $package);
    $template->set('table', $table);
    $template->set('builder', $this);

    return $template;
  }

  /**
   * @param Table $table
   * @return Field|null
   */
  public function getIdentityField(Table $table)
  {
    $fields = $table->getFields()->filter(function (Field $field) {
      return $field->isAutoIncrement() || $field->isIdentity() || $field->isPrimaryKey();
    });

    return $fields->exists() ? current($fields->toArray()) : null;
  }

  /**
   * @param Table $table
   * @return \Colibri\Collection\Collection
   */
  public function getPrimaryFields(Table $table)
  {
    return $table->getFields()->filter(function (Field $field) {
      return $field->isPrimaryKey();
    });
  }

  /**
   * @param Table $table
   * @return \Colibri\Collection\Collection
   */
  public function getUnsignedFields(Table $table)
  {
    return $table->getFields()->filter(function (Field $field) {
      return $field->isUnsigned();
    });
  }

  /**
   * @param Table $table
   * @return \Colibri\Collection\Collection
   */
  public function getNullableFields(Table $table)
  {
    return $table->getFields()->filter(function (Field $field) {
      return $field->isNullable();
    });
  }

  /**
   * @param Table $table
   * @return \Colibri\Collection\Collection
   */
  public function getEnumTypedFields(Table $table)
  {
    return $table->getFields()->filter(function (Field $field) {
      return $field->getType() instanceof EnumType;
    });
  }

  /**
   * @param Table $table
   * @return \Colibri\Collection\Collection
   */
  public function getDefaultValuesFields(Table $table)
  {
    return $table->getFields()->filter(function (Field $field) {
      return $field->getDefault() !== null;
    });
  }

  /**
   * @return XmlParser
   */
  public function getParser()
  {
    return $this->parser;
  }

  /**
   * @return string
   */
  public function getNamespace()
  {
    return $this->namespace;
  }

  /**
   * @return Database
   */
  public function getSchema()
  {
    return $this->schema;
  }

}