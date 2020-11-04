<?php

define('APP_PATH', dirname(__FILE__));

$publicPath = realpath(dirname(__FILE__) . '/../public');
$documentRoot = realpath($_SERVER['DOCUMENT_ROOT']);
define('BASE_URL', str_replace('\\', '/', str_replace($documentRoot, '', $publicPath)));
// var_dump (BASE_URL,$publicPath,realpath($_SERVER['DOCUMENT_ROOT']));
$config = array();

$config['db'] = array(
  'driver' => 'sqlite',
  'uri' => 'sqlite:' . APP_PATH . '/db/tickets.db',
  'database' => '',
  'host' => '',
  'user' => '',
  'password' => ''
);

if (!file_exists(APP_PATH . '/db/tickets.db')) {
  $file = fopen(APP_PATH . '/db/tickets.db', 'w');
  fclose($file);
  unset($file);
}
