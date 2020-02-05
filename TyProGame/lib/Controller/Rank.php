<?php

namespace MyApp\Controller;

class Rank extends \MyApp\Controller {

  public $which;

  public function run() {

    if (isset($_GET['which'])) {
      $this->which = $_GET['which'];
    }
    if (isset($_POST['which'])) {
      $this->which = $_POST['which'];
    }
    $userModel = new \MyApp\Model\User();
    $this->setValues('users', $userModel->sortRank($this->which));

  }

}
