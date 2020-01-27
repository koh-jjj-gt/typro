<?php

namespace MyApp\Exception;

class UnmatchCurrentEmail extends \Exception {
  protected $message = '現在のメールアドレスが正しくありません';
}
