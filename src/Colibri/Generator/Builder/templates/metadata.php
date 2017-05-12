<?php

use Colibri\Generator\Template\Template;

/**
 * @var $this Template
 * @var $metadata array
 */

echo "<?php\n\n";

echo $this->render('templates/phpdocInfo.php') . PHP_EOL;

?>

return <?php echo var_export($metadata); ?>;