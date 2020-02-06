<?php

ini_set('display_errors', 1);

define('DSN', 'mysql:dbhost=us-cdbr-iron-east-04.cleardb.net;dbname=heroku_cdfd56027dcc86e');
define('DB_USERNAME', 'bb06f54de49788');
define('DB_PASSWORD', 'a5407c5b');


define('SITE_URL', 'http://' . $_SERVER['HTTP_HOST']);

require_once(__DIR__ . '/../lib/functions.php');
require_once(__DIR__ . '/autoload.php');

session_start();
