<?php

ini_set('display_errors', 1);

define('DSN', 'mysql:dbhost=us-cdbr-iron-east-04.cleardb.net;dbname=heroku_cdfd56027dcc86e');
define('DB_USERNAME', 'bb06f54de49788');
define('DB_PASSWORD', 'a5407c5b');


$db = parse_url($_SERVER['CLEARDB_DATABASE_URL']);
$db['dbname'] = ltrim($db['path'], '/');
$dsn = "mysql:host={$db['host']};dbname={$db['dbname']};charset=utf8";
$db = new PDO($dsn, $db['user'], $db['pass']);
$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);



define('SITE_URL', 'http://' . $_SERVER['HTTP_HOST']);

require_once(__DIR__ . '/../lib/functions.php');
require_once(__DIR__ . '/autoload.php');

session_start();
