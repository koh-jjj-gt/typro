<?php

namespace MyApp\Exception;

class DuplicateEmail extends \Exception {
  protected $message = '既に使用されているメールアドレスです';
}
