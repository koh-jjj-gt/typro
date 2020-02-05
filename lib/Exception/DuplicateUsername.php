<?php

namespace MyApp\Exception;

class DuplicateUsername extends \Exception {
  protected $message = 'このユーザー名は既に使用されています';
}
