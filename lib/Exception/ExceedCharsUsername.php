<?php

namespace MyApp\Exception;

class ExceedCharsUsername extends \Exception {
  protected $message = '20文字以内にしてください';
}
