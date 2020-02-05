<?php

namespace MyApp\Controller;

class Index extends \MyApp\Controller {

  public function run() {
    if (!$this->isLoggedIn()) {
      header('Location: ' . SITE_URL . '/index_notLoggedIn.php');
      exit;
    }

    // Register highest score
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['score'])) {
      $this->registerPostProcess();
    }
  }

  protected function registerPostProcess() {
    $arrayOfSessionMe = (array)$_SESSION['me'];
    $userModel = new \MyApp\Model\User();
    $which = $_POST['which'];

    switch ($which) {
      case 0:
        $user = $userModel->registerHighestScore([
          'id' => $arrayOfSessionMe['id'],
          'htmlscore' => $_POST['score'],
          'which' => $_POST['which']
        ]);
        break;
      case 1:
        $user = $userModel->registerHighestScore([
          'id' => $arrayOfSessionMe['id'],
          'cssscore' => $_POST['score'],
          'which' => $_POST['which']
        ]);
        break;
      case 2:
        $user = $userModel->registerHighestScore([
          'id' => $arrayOfSessionMe['id'],
          'jsscore' => $_POST['score'],
          'which' => $_POST['which']
        ]);
        break;
      case 3:
        $user = $userModel->registerHighestScore([
          'id' => $arrayOfSessionMe['id'],
          'phpscore' => $_POST['score'],
          'which' => $_POST['which']
        ]);
        break;
    }
    session_regenerate_id(true);
    $_SESSION['me'] = $user;
    header('Location: rank.php?which=' . $which);
    exit;
  }

}
