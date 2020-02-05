<?php

namespace MyApp\Exception;

class InvalidHighestScore extends \Exception {
  protected $message = 'スコアが正常に登録されませんでした';
}
