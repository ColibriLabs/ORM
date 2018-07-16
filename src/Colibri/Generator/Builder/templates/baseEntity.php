<?php

use Colibri\Collection\Collection;
use Colibri\Common\Inflector;
use Colibri\Generator\Builder\EntityBuilder;
use Colibri\Generator\Template\Template;
use Colibri\Schema\Field;
use Colibri\Schema\Table;

/**
 * @var $this          Template
 * @var $table         Table
 * @var $primaryFields Collection|Field[]
 * @var $enumeration   Collection|Field[]
 * @var $namespace     string
 */

echo "<?php\n\n";

echo $this->render('templates/phpdocInfo.php') . PHP_EOL;

$class = sprintf(EntityBuilder::BASE_ENTITY_TEMPLATE, $table->getClassifyName());

$commonClass = sprintf(EntityBuilder::ENTITY_TEMPLATE, $table->getClassifyName());
$namespaceCommonClass = sprintf('%s\\%s', $namespace, $commonClass);

?>

namespace <?php echo $namespace; ?>\Base;

use Colibri\Core\Entity;

/**
* Entity class for representation table '<?php echo $table->getTableName(); ?>'
*/
class <?php echo $class; ?> extends Entity
{

const TABLE = '<?php echo $table->getTableName(); ?>';

<?php foreach ($table->getFields() as $field): ?>
  const <?php echo $field->getConstantifyName(); ?> = '<?php echo sprintf('%s.%s', $table->getTableName(), $field->getColumn()); ?>';
<?php endforeach; ?>
<?php foreach ($table->getFields() as $field): ?>
  const <?php echo $field->getConstantifyName(); ?>_KEY = '<?php echo $field->getColumn(); ?>';
<?php endforeach; ?>
<?php foreach ($enumeration as $field): foreach ($field->getType()->getExtra() as $enum): ?>
  const ENUM_<?php echo sprintf('%s_%s', $field->getConstantifyName(), Inflector::constantify($enum)); ?> = '<?php echo $enum; ?>';
<?php endforeach; endforeach; ?>
<?php foreach ($table->getFields() as $field): ?>

  /**
  * @var <?php echo $field->getType()->getPhpName() . PHP_EOL; ?>
  */
  public $<?php echo $field->getCamelizeName(); ?>;
<?php endforeach; ?>

<?php foreach ($table->getFields() as $field): ?>
  /**
  * @return <?php echo $field->getType()->getPhpName() . PHP_EOL; ?>
  */
  public function get<?php echo $field->getClassifyName(); ?>()
  {
  return $this-><?php echo $field->getCamelizeName(); ?>;
  }

<?php endforeach; ?>

<?php foreach ($table->getFields() as $field): ?>
  /**
  * @param <?php echo $field->getType()->getPhpName(); ?> $<?php echo $field->getCamelizeName() . PHP_EOL; ?>
  * @return $this
  */
  public function set<?php echo $field->getClassifyName(); ?>($<?php echo $field->getCamelizeName(); ?>)
  {
  $this-><?php echo $field->getCamelizeName(); ?> = $<?php echo $field->getCamelizeName(); ?>;

  return $this;
  }

<?php endforeach; ?>
}