<?php

namespace MyApp\Exception;

class InvalidEmail extends \Exception {
  protected $message = 'メールアドレスを正しく入力してください';
}
