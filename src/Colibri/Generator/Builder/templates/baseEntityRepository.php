<?php

use Colibri\Collection\Collection;
use Colibri\Core\ResultSet\ResultSetIterator;
use Colibri\Generator\Builder\EntityBuilder;
use Colibri\Generator\Template\Template;
use Colibri\Schema\Field;
use Colibri\Schema\Table;

/**
 * @var $this Template
 * @var $table Table
 * @var $primaryFields Collection|Field[]
 * @var $namespace string
 */

echo "<?php\n";

echo $this->render('templates/phpdocInfo.php') . PHP_EOL;

$class = sprintf(EntityBuilder::BASE_ENTITY_REPOSITORY_TEMPLATE, $table->getClassifyName());
$commonClass = sprintf(EntityBuilder::ENTITY_REPOSITORY_TEMPLATE, $table->getClassifyName());

$namespaceCommonClass = sprintf('%s\\%s', $namespace, $commonClass);

$entityClass = sprintf(EntityBuilder::ENTITY_TEMPLATE, $table->getClassifyName());
$namespaceEntityClass = sprintf('%s\\%s', $namespace, $entityClass);

$resultSetReflection = new ReflectionClass(ResultSetIterator::class);

?>

namespace <?php echo $namespace; ?>\Base;

use Colibri\Core\Repository;
use Colibri\Query\Statement\Comparison\Cmp;
use Colibri\Query\Statement\OrderBy;
use <?php echo $namespaceCommonClass; ?>;
use <?php echo $namespaceEntityClass; ?>;
use <?php echo $resultSetReflection->getName(); ?>;

/**
 * Magic methods for query-builder and access to the fields data
 *
<?php foreach($table->getFields() as $field): ?>
 * @method <?php echo $entityClass; ?> findOneBy<?php echo $field->getClassifyName(); ?>($<?php echo $field->getColumn(); ?>);
 * @method <?php echo $resultSetReflection->getShortName(); ?> findBy<?php echo $field->getClassifyName(); ?>($<?php echo $field->getColumn(); ?>);
 * @method <?php echo $commonClass; ?> filterBy<?php echo $field->getClassifyName(); ?>($<?php echo $field->getColumn(); ?>, $cmp = Cmp::EQ);
 * @method <?php echo $commonClass; ?> orderBy<?php echo $field->getClassifyName(); ?>($vector = OrderBy::ASC);
 * @method <?php echo $commonClass; ?> groupBy<?php echo $field->getClassifyName(); ?>();
<?php endforeach; ?>
*/

class <?php echo $class; ?> extends Repository
{
  
  /**
   * <?php echo $class; ?> constructor.
   */
  public function __construct()
  {
    parent::__construct(<?php echo $entityClass; ?>::class);
  }
  
  /**
   * @param integer $id Identifier
   * @return <?php echo $entityClass; ?> Entity instance
   */
  public static function findByPK($id)
  {
    /** @var <?php echo $entityClass; ?> $entity */
    $repository = new <?php echo $commonClass; ?>();
    $entity = $repository->retrieve($id);
    
    return $entity;
  }

}
