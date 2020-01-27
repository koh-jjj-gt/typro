<?php

namespace MyApp\Controller;

class Signup extends \MyApp\Controller {

  public function run() {
    if ($this->isLoggedIn()) {
      header('Location: ' . SITE_URL);
      exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $this->postProcess();
    }
  }

  protected function postProcess() {
    // validate
    try {
      $this->_validate();
    } catch (\MyApp\Exception\InvalidUsername $e) {
      $this->setErrors('username', $e->getMessage());
    } catch (\MyApp\Exception\InvalidEmail $e) {
      $this->setErrors('email', $e->getMessage());
    } catch (\MyApp\Exception\InvalidPassword $e) {
      $this->setErrors('password', $e->getMessage());
    } catch (\MyApp\Exception\EmptyPost $e) {
      $this->setErrors('empty', $e->getMessage());
    } catch (\MyApp\Exception\ExceedCharsUsername $e) {
      $this->setErrors('username', $e->getMessage());
    } catch (\MyApp\Exception\ExceedCharsPassword $e) {
      $this->setErrors('password', $e->getMessage());
    }

    $this->setValues('username', $_POST['username']);
    $this->setValues('email', $_POST['email']);

    if ($this->hasError()) {
      return;
    } else {
      // create user & login
      try {
        $this->_createAndLogin();
      } catch (\MyApp\Exception\DuplicateUsernameOrEmail $e) {
        $this->setErrors('email', $e->getMessage());
        return;
      }

    }
  }

  private function _createAndLogin() {
    $userModel = new \MyApp\Model\User();
    $userModel->create([
      'username' => $_POST['username'],
      'email' => $_POST['email'],
      'password' => $_POST['password']
    ]);
    $user = $userModel->login([
      'username' => $_POST['username'],
      'email' => $_POST['email'],
      'password' => $_POST['password']
    ]);

    // login処理
    session_regenerate_id(true);
    $_SESSION['me'] = $user;

    // redirect to home
    header('Location: ' . SITE_URL);
    exit;
  }

  private function _validate() {
    if (!isset($_POST['token']) || $_POST['token'] !== $_SESSION['token']) {
      echo "無効なトークンです！";
      exit;
    }

    if ($_POST['username'] === '' || $_POST['email'] === '' || $_POST['password'] === '') {
      throw new \MyApp\Exception\EmptyPost();
    }

    if (!isset($_POST['username'])) {
      throw new \MyApp\Exception\InvalidUsername();
    }

    if (mb_strlen($_POST['username'], 'UTF-8') > 20) {
      throw new \MyApp\Exception\ExceedCharsUsername();
    }

    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
      throw new \MyApp\Exception\InvalidEmail();
    }

    if (!preg_match('/\A[a-zA-Z0-9]+\z/', $_POST['password'])) {
      throw new \MyApp\Exception\InvalidPassword();
    }

    if(strlen($_POST['password']) < 4 || 16 < strlen($_POST['password'])) {
      throw new \MyApp\Exception\ExceedCharsPassword();
    }
  }

}
