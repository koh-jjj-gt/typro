<?php

namespace MyApp\Controller;

class Profile extends \MyApp\Controller {
  public $which = -1;

  public function run() {
    if (!$this->isLoggedIn()) {
      header('Location: ' . SITE_URL . '/index_notLoggedIn.php');
      exit;
    }

    // post method
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      if (isset($_POST['reset-html']) ||
      isset($_POST['reset-css']) ||
      isset($_POST['reset-js']) ||
      isset($_POST['reset-php'])) {
        $this->_postprocessThatResetScore();
      }
      if (isset($_POST['new-username'])) {
        $this->_postprocessThatUpdateUsername();
      }
      if (isset($_POST['new-email'])) {
        $this->_postprocessThatUpdateEmail();
      }
      if (isset($_POST['new-password'])) {
        $this->_postprocessThatUpdatePassword();
      }
    }
  }

  // reset score
  private function _postprocessThatResetScore() {
    $arrayOfSessionMe = (array)$_SESSION['me'];

    if (isset($_POST['reset-html'])) {
      $this->which = 0;
      $arrayOfSessionMe['htmlscore'] = 0;
    } else if (isset($_POST['reset-css'])) {
      $this->which = 1;
      $arrayOfSessionMe['cssscore'] = 0;
    } else if (isset($_POST['reset-js'])) {
      $this->which = 2;
      $arrayOfSessionMe['jsscore'] = 0;
    } else if (isset($_POST['reset-php'])) {
      $this->which = 3;
      $arrayOfSessionMe['phpscore'] = 0;
    }
    if ($this->which >= 0) {
      $userModel = new \MyApp\Model\User();
      $userModel->reset([
        'id' => $arrayOfSessionMe['id'],
        'which' => $this->which
      ]);
      session_regenerate_id(true);
      $_SESSION['me'] = (object)$arrayOfSessionMe;
      header('Location: ' . SITE_URL . '/profile.php');
      exit;
    }
  }


  // update username
  private function _postprocessThatUpdateUsername() {
    try {
      $this->_validateUsername();
    } catch (\MyApp\Exception\ExceedCharsUsername $e) {
      $this->setErrors('username', $e->getMessage());
    } catch (\MyApp\Exception\EmptyPost $e) {
      $this->setErrors('username', $e->getMessage());
    } catch (\MyApp\Exception\InvalidUsername $e) {
      $this->setErrors('username', $e->getMessage());
    }

    if ($this->hasError()) {
      return;
    } else {
      try {
        $this->_updateUsername();
      } catch (\MyApp\Exception\DuplicateUsername $e) {
        $this->setErrors('username', $e->getMessage());
      }
    }
  }

  private function _validateUsername() {
//     if (mb_strlen($_POST['new-username'], 'UTF-8') > 20) {
//       throw new \MyApp\Exception\ExceedCharsUsername();
//     }
    if ($_POST['new-username'] === '') {
      throw new \MyApp\Exception\EmptyPost();
    }
    if (!isset($_POST['new-username'])) {
      throw new \MyApp\Exception\InvalidUsername();
    }
  }

  private function _updateUsername() {
    $arrayOfSessionMe = (array)$_SESSION['me'];
    $arrayOfSessionMe['username'] = $_POST['new-username'];
    $userModel = new \MyApp\Model\User();
    $userModel->updateUsername([
      'id' => $arrayOfSessionMe['id'],
      'username' => $arrayOfSessionMe['username']
    ]);
    session_regenerate_id(true);
    $_SESSION['me'] = (object)$arrayOfSessionMe;
    header('Location: profile.php?pos=' . 1);
    exit;
  }


  // update email
  private function _postprocessThatUpdateEmail() {
    try {
      $this->_validateEmail();
    } catch (\MyApp\Exception\EmptyPost $e) {
      $this->setErrors('email', $e->getMessage());
    } catch (\MyApp\Exception\InvalidEmail $e) {
      $this->setErrors('email', $e->getMessage());
    } catch (\MyApp\Exception\UnmatchCurrentEmail $e) {
      $this->setErrors('email', $e->getMessage());
    }

    $this->setValues('curEmail', $_POST['current-email']);
    $this->setValues('newEmail', $_POST['new-email']);

    if ($this->hasError()) {
      return;
    } else {
      try {
        $this->_updateEmail();
      } catch (\MyApp\Exception\DuplicateEmail $e) {
        $this->setErrors('email', $e->getMessage());
      } catch (\MyApp\Exception\SuccessUpdate $e) {
        $this->setValues('curEmail', '');
        $this->setValues('newEmail', '');
        $this->setErrors('email', $e->getMessage());
      }
    }
  }

  private function _validateEmail() {
    if ($_POST['new-email'] === '' || $_POST['current-email'] === '') {
      throw new \MyApp\Exception\EmptyPost();
    }
    if (!isset($_POST['new-email']) || !isset($_POST['current-email']) || !filter_var($_POST['new-email'], FILTER_VALIDATE_EMAIL)) {
      throw new \MyApp\Exception\InvalidEmail();
    }
    $arrayOfSessionMe = (array)$_SESSION['me'];
    if ($_POST['current-email'] !== $arrayOfSessionMe['email']) {
      throw new \MyApp\Exception\UnmatchCurrentEmail();
    }
  }

  private function _updateEmail() {
    $userModel = new \MyApp\Model\User();
    $userModel->updateEmail([
      'current-email' => $_POST['current-email'],
      'new-email' => $_POST['new-email']
    ]);
    session_regenerate_id(true);
    $arrayOfSessionMe = (array)$_SESSION['me'];
    $arrayOfSessionMe['email'] = $_POST['new-email'];
    $_SESSION['me'] = (object)$arrayOfSessionMe;
    if ($arrayOfSessionMe['email'] === $_POST['new-email']) {
      throw new \MyApp\Exception\SuccessUpdate();
    }
  }


  // update password
  private function _postprocessThatUpdatePassword() {
    try {
      $this->_validatePassword();
    } catch (\MyApp\Exception\EmptyPost $e) {
      $this->setErrors('password', $e->getMessage());
    } catch (\MyApp\Exception\InvalidPassword $e) {
      $this->setErrors('password', $e->getMessage());
    } catch (\MyApp\Exception\ExceedCharsPassword $e) {
      $this->setErrors('password', $e->getMessage());
    } catch (\MyApp\Exception\UnmatchCurrentPassword $e) {
      $this->setErrors('password', $e->getMessage());
    }

    if ($this->hasError()) {
      return;
    } else {
      try {
        $this->_updatePassword();
      } catch (\MyApp\Exception\InvalidPassword $e) {
        $this->setErrors('password', $e->getMessage());
      } catch (\MyApp\Exception\SuccessUpdate $e) {
        $this->setErrors('password', $e->getMessage());
      }
    }
  }

  private function _validatePassword() {
    if ($_POST['new-password'] === '' || $_POST['current-password'] === '') {
      throw new \MyApp\Exception\EmptyPost();
    }
    if (!isset($_POST['new-password']) || !isset($_POST['current-password']) || !preg_match('/\A[a-zA-Z0-9]+\z/', $_POST['new-password'])) {
      throw new \MyApp\Exception\InvalidPassword();
    }
    if(strlen($_POST['new-password']) < 4 || 16 < strlen($_POST['new-password'])) {
      throw new \MyApp\Exception\ExceedCharsPassword();
    }
    $arrayOfSessionMe = (array)$_SESSION['me'];
    if (!password_verify($_POST['current-password'], $arrayOfSessionMe['password'])) {
      throw new \MyApp\Exception\UnmatchCurrentPassword();
    }
  }

  private function _updatePassword() {
    $arrayOfSessionMe = (array)$_SESSION['me'];
    $userModel = new \MyApp\Model\User();
    $user = $userModel->updatePassword([
      'id' => $arrayOfSessionMe['id'],
      'new-password' => $_POST['new-password']
    ]);
    session_regenerate_id(true);
    $_SESSION['me'] = $user;
    if (!empty($user)) {
      throw new \MyApp\Exception\SuccessUpdate();
    }
  }
}
