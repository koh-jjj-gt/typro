<?php

namespace MyApp\Exception;

class ExceedCharsPassword extends \Exception {
  protected $message = '4〜16文字にしてください';
}
