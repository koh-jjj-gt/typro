<?php

namespace MyApp\Exception;

class EmptyPost extends \Exception {
  protected $message = '入力してください';
}
