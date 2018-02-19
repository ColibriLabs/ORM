<?php

namespace Demo;

use Colibri\ColibriORM;
use Colibri\Common\Configuration;
use Colibri\Extension\EventSubscriber\RuntimeDebugger;
use Colibri\Extension\EventSubscriber\SoftDeletion;
use ProCard\Models\CoWorker;


$timeStart = microtime(true);

set_exception_handler(function(\Throwable $exception){
  $traceBlock = <<<HTML
<a href="javascript: (function(){document.getElementById('trace').style.display = 'block'})();">show trace</a>
<div style="display: none" id="trace"><b>%s</b></div>
HTML;
  $html = '<b>%s</b>: <i>%s</b><pre>%s:%s<div>%s</div></pre>';
  $html = sprintf(
    $html, get_class($exception),
    $exception->getMessage(),
    $exception->getFile(), $exception->getLine(),
    sprintf($traceBlock, $exception->getTraceAsString())
  );
  die($html);
});

register_shutdown_function(function () use ($timeStart) {
  die(sprintf('memory: %01.4fMiB, time: %01.4fs', memory_get_usage() / 1024 / 1024, microtime(true) - $timeStart));
});

include_once __DIR__ . '/../../vendor/autoload.php';
//
$configuration = new Configuration(include_once sprintf('%s/config/colibri_orm.php', __DIR__));

$dev = sprintf('%s/config/%s', __DIR__, $configuration->path('colibri_orm.dev_configuration'));

if(file_exists($dev)) {
  $configuration->merge(new Configuration(include_once $dev));
}

ColibriORM::initialize($configuration);

$dispatcher = ColibriORM::getServiceContainer()->getDispatcher();

$dispatcher->subscribeListener(new SoftDeletion($configuration));
$dispatcher->subscribeListener(new RuntimeDebugger());
