<?php

use Colibri\Generator\Template\Template;

/**
 * @var $this Template
 * @var $namespace string
 */

echo "<?php\n\n";

echo $this->render('templates/phpdocInfo.php') . PHP_EOL;

?>

$classLoader = new Composer\Autoload\ClassLoader();
$classLoader->setPsr4('<?php echo $namespace; ?>\\', __DIR__);
$classLoader->register(true);

return $classLoader;