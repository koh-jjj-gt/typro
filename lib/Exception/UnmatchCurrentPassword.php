<?php

namespace MyApp\Exception;

class UnmatchCurrentPassword extends \Exception {
  protected $message = '現在のパスワードが正しくありません';
}
