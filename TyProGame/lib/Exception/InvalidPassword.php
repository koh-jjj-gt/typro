<?php

namespace MyApp\Exception;

class InvalidPassword extends \Exception {
  protected $message = 'パスワードは半角英数字で入力してください';
}
