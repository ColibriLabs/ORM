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

$repository = new \ProCard\Models\ProductsRepository();

$query = $repository->createSelectQuery();

$query->clearSelectColumns();

//$query->setParameterized(true);
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

//$criteria = new Criteria();
//$criteria->where('1', '2');

$insert = new Insert($query->getConnection());

$insert->setTableInto('teste');
$insert->setDataBatch([
  'qwe' => 123,
  Products::CATEGORY_ID_KEY => 123
]);

$insert->setParameterized(true);

//var_dump($query->toSQL(), $query->getPlaceholders());
//
var_dump($insert->toSQL(), $insert->getPlaceholders());

$query = new Select($query->getConnection());
$query->setReplaceAliases(true);

$query->setColumnAlias(new Column('P.surname'), 'name');

$query->setTableAlias(new Table('products'), 'P');
$query->setFromTable('P');

$query->addSelectColumns([
  'P.name'
]);

$update = new \Colibri\Query\Builder\Update($query->getConnection());
$update->setParameterized(true);
$update->setReplaceAliases(true);

$update->setTableAlias(new Table('products'), 'P');
$update->table('P');

$update->setDataBatch([
  'P.name' => '123qwe',
  'fuck' => 123
]);

$delete = new \Colibri\Query\Builder\Delete($query->getConnection());
//$delete->setParameterized(true);
$delete->setFromTable('test');

$delete->where('cre', 2);
$sub = $delete->subWhere(Cmp::VEL)->where('b', 3, '=', 'OR')->where('b', 4, '=', 'OR')->where('a', 5);

$sub->subWhere(Cmp::CONJUNCTION_XOR)
  ->where('c', 123)->where('c', 312, Cmp::EQ, Cmp::VEL);

var_dump($delete->toSQL(), $delete->getPlaceholders());

var_dump($query->toSQL(), $update->toSQL(), $update->getPlaceholders());

//$imagePath = __DIR__ . '/../../static/colibri.png';
//$imageResource = file_get_contents($imagePath);

//die;

//$userRepository = new MyUsersRepository();
//
//$qb = $userRepository->getQuery();
//
//$qb->innerJoin('users_tags', [
//  [MyUsers::ID, 'users_tags.user_id',],
//  [MyUsers::ID, 'users_tags.user_parent_id', Cmp::GT, Cmp::CONJUNCTION_OR]
//]);
//$qb->innerJoin('tags', ['users_tags.tag_id', 'tags.id']);
//
//die(var_dump($qb->toSQL()));
//
//$userMetadata = $userRepository->getEntityMetadata();
//
//$userRepository->filterById(123);
//
//$collection = $userRepository->findAll();
//
///** @var $user MyUsers */
//$user = $userRepository->findOne(4);
//
//$user->setUserName(sprintf('Anna 0x%s', dechex(time())));
//$user->setIsTrusted(true);
////$user->setFileBlob($imageResource);
//$user->setFileBlobBase64($imageResource);
//
////$userRepository->persist($user);
//
//
//var_dump($user);
//
//$resultSet = new ResultSetIterator($userRepository, $userRepository->execute());
//
////var_dump($resultSet->getCollection()->toArray());