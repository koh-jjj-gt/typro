<?php

namespace MyApp\Exception;

class DuplicateUsernameOrEmail extends \Exception {
  protected $message = '入力したユーザー名またはメールアドレスは既に使用されています';
}
