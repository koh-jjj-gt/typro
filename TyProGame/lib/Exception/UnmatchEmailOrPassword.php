<?php

namespace MyApp\Exception;

class UnmatchEmailOrPassword extends \Exception {
  protected $message = '正しく入力してください';
}
