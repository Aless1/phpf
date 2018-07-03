<?php
error_reporting(E_ERROR);

define('ROOT', __DIR__);
define('APP_ROOT', ROOT.'/app');

require ROOT.'/vendor/autoload.php';
require APP_ROOT.'/App.php';

$app = getapp();
$app->run('http');