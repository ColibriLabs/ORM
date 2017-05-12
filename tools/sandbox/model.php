<?php

use Colibri\Connection\ConnectionEvent;
use Colibri\Core\ResultSet\ResultSetIterator;
use Colibri\Query\Statement\Comparison\Cmp;
use Colibri\ServiceContainer\ServiceLocator;
use ProCard\Models\MyUsers;
use ProCard\Models\MyUsersRepository;

include_once './_init.php';

$colibri = ServiceLocator::instance();
$colibri->getDispatcher()->addListener(ConnectionEvent::ON_QUERY, function (ConnectionEvent $event) {
//  var_dump($event->getQuery());
});
//
//$a = range(1, 10);
//
//foreach ($a as $item) {
//  var_dump($item, next($a));
//}

$colibri->getLogger()->error('test error', ['abc' => 123]);

$repository = new \ProCard\Models\ProductsRepository();

$query = $repository->createSelectQuery();

$query->where('a', 1);
$query->where('a', 2);
$query->where('a', 3, '=', 'OR');
$query->where('a', 4);

$query->where('b', 2);
$sub = $query->subWhere(Cmp::VEL)->where('b', 3, '=', 'OR')->where('b', 4, '=', 'OR')->where('a', 5);

$sub->subWhere(Cmp::CONJUNCTION_XOR)
  ->where('c', 123)->where('c', 312, Cmp::EQ, Cmp::VEL);

$sub->sub(Cmp::ET)->where('z', 321)->where('x', 333, Cmp::EQ, Cmp::VEL);

$sub->where('d', 777);
$query->where('asdasd', 'dasasdasd');

var_dump($query->toSQL(), $colibri->getConfiguration()->toYaml());

die();

//$imagePath = __DIR__ . '/../../static/colibri.png';
//$imageResource = file_get_contents($imagePath);

//die;

//$userRepository = new MyUsersRepository();
//
//$qb = $userRepository->getFilterQuery();
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
////$user->setFileBlobBase64($imageResource);
//
////$userRepository->persist($user);
//
//
//var_dump($user);
//
//$resultSet = new ResultSetIterator($userRepository, $userRepository->execute());
//
////var_dump($resultSet->getCollection()->toArray());