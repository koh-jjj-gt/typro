<?php

/*
MyApp
index.php controller
MyApp\Controller\Index
-> lib/Controller/Index.php
*/

spl_autoload_register(function($class) {
  // バックスラッシュをエスケープしている
  $prefix = 'MyApp\\';

  // クラス名がMyAppから始まるなら
  if (strpos($class, $prefix) === 0) {

    // Controller\Index
    $className = substr($class, strlen($prefix));

    // /../lib/MyApp/Controller/Index.php
    $classFilePath = __DIR__ . '/../lib/' . str_replace('\\', '/', $className) . '.php';
    if (file_exists($classFilePath)) {
      require $classFilePath;
    }
  }
});
