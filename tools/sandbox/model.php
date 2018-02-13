<?php

use Colibri\Connection\ConnectionEvent;
use Colibri\Core\ResultSet\ResultSetIterator;
use Colibri\Query\Builder\Insert;
use Colibri\Query\Builder\Select;
use Colibri\Query\Criteria;
use Colibri\Query\Expr\Column;
use Colibri\Query\Expr\Func\Concat;
use Colibri\Query\Expr\Func\Rand;
use Colibri\Query\Expr\Raw;
use Colibri\Query\Expr\Table;
use Colibri\Query\Statement\Comparison\Cmp;
use Colibri\ServiceContainer\ServiceLocator;
use ProCard\Models\MyUsers;
use ProCard\Models\MyUsersRepository;
use ProCard\Models\Products;

include_once './_init.php';

error_reporting(E_ALL);
ini_set('display_errors', 'On');

$repository = new \ProCard\Models\CategoryRepository();

$category = new \ProCard\Models\Category();

$repository->remove($category);

$query = $repository->createSelectQuery();

$query->clearSelectColumns();

$query->setReplaceAliases(true);

$query->where('a', 1);
$query->where('a', 2);
$query->where('a', 3, '=', 'OR');
$query->where('a', 4);

$query->setColumnAlias(new Column(Products::NAME), 'nm');

$query->where('cre', 2);
$sub = $query->subWhere(Cmp::VEL)->where('b', 3, '=', 'OR')->where('b', 4, '=', 'OR')->where('a', 5);

$sub->subWhere(Cmp::CONJUNCTION_XOR)
  ->where('c', 123)->where('c', 312, Cmp::EQ, Cmp::VEL);

$sub->sub(Cmp::ET)->where('z', 321)->where('x', 333, Cmp::EQ, Cmp::VEL);

$sub->where('d', 777);

$sub->whereIn('qwe', [1, 2, 3]);

$query->where('asdasd', 'dasasdasd');

$query->addSelectColumn(new Concat('qwe', '123', new Column('user.hash')), 'total_str');
$query->addSelectColumns([
  'qwe', ['qwe2', 'qwe2_alias'], [Products::CREATED_AT, 'cre'], 'nm'
]);

$query->orderBy('qwe2_alias');
$query->groupBy('cre');

$query->setComment(sprintf("\n%s\n", __FILE__));

$query->setParameterized(true);

echo $query . PHP_EOL;

$insert = new Insert($query->getConnection());

$insert->setTableInto('teste');
$insert->setDataBatch([
  'qwe' => 123,
  Products::CATEGORY_ID_KEY => 123
]);

$insert->setParameterized(true);

echo $insert . PHP_EOL;

var_dump($insert->getPlaceholders());

$query = new Select($query->getConnection());
$query->setReplaceAliases(true);

$query->setColumnAlias(new Column('P.surname'), 'name');

$query->setTableAlias(new Table('products'), 'P');
$query->setFromTable('P');
$query->setComment('Hello World! I will remove you!');
$query->addSelectColumns([
  'P.name'
]);

echo $query . PHP_EOL;

$update = new \Colibri\Query\Builder\Update($query->getConnection());
$update->setParameterized(true);
$update->setReplaceAliases(true);

$update->setTableAlias(new Table('products'), 'P');
$update->table('P');

$update->setDataBatch([
  'P.name' => '123qwe',
  'fuck' => 123
]);

echo $update . PHP_EOL;

$delete = new \Colibri\Query\Builder\Delete($query->getConnection());
//$delete->setParameterized(true);
$delete->setFromTable('test');

$delete->where('cre', 2);
$sub = $delete->subWhere(Cmp::VEL)->where('b', 3, '=', 'OR')->where('b', 4, '=', 'OR')->where('a', 5);

$sub->subWhere(Cmp::CONJUNCTION_XOR)
  ->where('c', 123)->where('c', 312, Cmp::EQ, Cmp::VEL);
echo $delete . PHP_EOL;
