<?php

namespace MyApp\Model;

class User extends \MyApp\Model {

  public function create($values) {
    $stmt = $this->db->prepare("INSERT INTO users (username, email, password, created, modified) VALUES (:username, :email, :password, now(), now())");
    $res = $stmt->execute([
      ':username' => $values['username'],
      ':email' => $values['email'],
      ':password' => password_hash($values['password'], PASSWORD_DEFAULT)
    ]);
    if ($res === false) {
      throw new \MyApp\Exception\DuplicateUsernameOrEmail();
    }
  }

  public function login($values) {
    $stmt = $this->db->prepare("SELECT * FROM users WHERE username = :username AND email = :email");
    $stmt->execute([
      ':username' => $values['username'],
      ':email' => $values['email']
    ]);
    $stmt->setFetchMode(\PDO::FETCH_CLASS, 'stdClass');
    $user = $stmt->fetch();

    if (empty($user)) {
      throw new \MyApp\Exception\UnmatchEmailOrPassword();
    }
    if (!password_verify($values['password'], $user->password)) {
      throw new \MyApp\Exception\UnmatchEmailOrPassword();
    }

    return $user;
  }

  public function registerHighestScore($values) {

    switch ($values['which']) {
      case 0:
      $stmt = $this->db->prepare("UPDATE users SET htmlscore = :htmlscore WHERE id = :id AND htmlscore < :htmlscore");
      $stmt->execute([
        ':id' => $values['id'],
        ':htmlscore' => $values['htmlscore']
      ]);
      break;
      case 1:
      $stmt = $this->db->prepare("UPDATE users SET cssscore = :cssscore WHERE id = :id AND cssscore < :cssscore");
      $stmt->execute([
        ':id' => $values['id'],
        ':cssscore' => $values['cssscore']
      ]);
      break;
      case 2:
      $stmt = $this->db->prepare("UPDATE users SET jsscore = :jsscore WHERE id = :id AND jsscore < :jsscore");
      $stmt->execute([
        ':id' => $values['id'],
        ':jsscore' => $values['jsscore']
      ]);
      break;
      case 3:
      $stmt = $this->db->prepare("UPDATE users SET phpscore = :phpscore WHERE id = :id AND phpscore < :phpscore");
      $stmt->execute([
        ':id' => $values['id'],
        ':phpscore' => $values['phpscore']
      ]);
      break;
    }
    $stmt = $this->db->prepare("SELECT * FROM users WHERE id = :id");
    $stmt->execute([
      ':id' => $values['id']
    ]);
    $stmt->setFetchMode(\PDO::FETCH_CLASS, 'stdClass');
    $user = $stmt->fetch();

    if (empty($user)) {
      throw new \MyApp\Exception\UnmatchEmailOrPassword();
    }

    return $user;
  }

  public function sortRank($which) {
    $sql1 = 'SET @a = 0;';
    $stmt = $this->db->query($sql1);
    switch ($which) {
      case 0:
      $sql2 = 'SELECT @a:=@a+1 AS ranking, username, htmlscore FROM users WHERE NOT htmlscore = 0 ORDER BY htmlscore DESC LIMIT 100;';
      break;
      case 1:
      $sql2 = 'SELECT @a:=@a+1 AS ranking, username, cssscore FROM users WHERE NOT cssscore = 0 ORDER BY cssscore DESC LIMIT 100;';
      break;
      case 2:
      $sql2 = 'SELECT @a:=@a+1 AS ranking, username, jsscore FROM users WHERE NOT jsscore = 0 ORDER BY jsscore DESC LIMIT 100;';
      break;
      case 3:
      $sql2 = 'SELECT @a:=@a+1 AS ranking, username, phpscore FROM users WHERE NOT phpscore = 0 ORDER BY phpscore DESC LIMIT 100;';
      break;
    }
    $stmt = $this->db->query($sql2);
    $stmt->setFetchMode(\PDO::FETCH_CLASS, 'stdClass');
    $users = $stmt->fetchAll();
    return $users;
  }

  public function reset($values) {
    switch ($values['which']) {
      case 0:
      $stmt = $this->db->prepare("UPDATE users SET htmlscore = 0 WHERE id = :id");
      $stmt->execute([
        ':id' => $values['id']
      ]);
      break;
      case 1:
      $stmt = $this->db->prepare("UPDATE users SET cssscore = 0 WHERE id = :id");
      $stmt->execute([
        ':id' => $values['id']
      ]);
      break;
      case 2:
      $stmt = $this->db->prepare("UPDATE users SET jsscore = 0 WHERE id = :id");
      $stmt->execute([
        ':id' => $values['id']
      ]);
      break;
      case 3:
      $stmt = $this->db->prepare("UPDATE users SET phpscore = 0 WHERE id = :id");
      $stmt->execute([
        ':id' => $values['id']
      ]);
      break;
    }
    return;
  }

  public function updateUsername($values) {
    $stmt = $this->db->prepare("UPDATE users SET username = :username WHERE id = :id");
    $res = $stmt->execute([
      ':id' => $values['id'],
      ':username' => $values['username']
    ]);
    if ($res === false) {
      throw new \MyApp\Exception\DuplicateUsername();
    }
    return;
  }

  public function updateEmail($values) {
    $stmt = $this->db->prepare("UPDATE users SET email = :newemail WHERE email = :currentemail");
    $res = $stmt->execute([
      ':currentemail' => $values['current-email'],
      ':newemail' => $values['new-email']
    ]);
    if ($res === false) {
      throw new \MyApp\Exception\DuplicateEmail();
    }
    return;
  }

  public function updatePassword($values) {
    $stmt = $this->db->prepare("UPDATE users SET password = :newpassword WHERE id = :id");
    $res = $stmt->execute([
      ':id' => $values['id'],
      ':newpassword' => password_hash($values['new-password'], PASSWORD_DEFAULT)
    ]);
    if ($res === false) {
      throw new \MyApp\Exception\InvalidPassword();
    }

    $stmt = $this->db->prepare("SELECT * FROM users WHERE id = :id");
    $stmt->execute([
      ':id' => $values['id']
    ]);
    $stmt->setFetchMode(\PDO::FETCH_CLASS, 'stdClass');
    $user = $stmt->fetch();

    if (empty($user)) {
      throw new \MyApp\Exception\UnmatchEmailOrPassword();
    }

    return $user;
  }
}
