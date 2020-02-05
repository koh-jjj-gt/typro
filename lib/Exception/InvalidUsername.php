<?php

namespace MyApp\Exception;

class InvalidPassword extends \Exception {
  protected $message = 'ユーザー名を入力してください';
}
