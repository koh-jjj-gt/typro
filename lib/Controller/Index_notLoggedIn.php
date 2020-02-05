<?php

namespace MyApp\Controller;

class Index_notLoggedIn extends \MyApp\Controller {

  public function run() {

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      if (isset($_POST['signup-input'])) {
        header('Location: ' . SITE_URL . '/signup.php');
        exit;
      }
      if (isset($_POST['login-input'])) {
        header('Location: ' . SITE_URL . '/login.php');
        exit;
      }
      if (isset($_POST['rank-input'])) {
        header('Location: ' . SITE_URL . '/rank.php');
        exit;
      }
    }

  }

}
