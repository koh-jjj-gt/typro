<?php

namespace MyApp;

class Model {
  protected $db;
  protected $dsn;

//   public function __construct() {
//     try {
//       $this->db = new \PDO(DSN, DB_USERNAME, DB_PASSWORD);
//     } catch (\PDOException $e) {
//       echo $e->getMessage();
//       exit;
//     }
//   }
  public function __construct() {
    try {
        $this->db = parse_url($_SERVER['CLEARDB_DATABASE_URL']);
        $this->db['dbname'] = ltrim($this->db['path'], '/');
        $this->dsn = "mysql:host={$db['host']};dbname={$db['dbname']};charset=utf8";
        $this->db = new \PDO($this->dsn, $this->db['user'], $this->db['pass']);
        $this->db->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);
        $this->db->setAttribute(\PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
//       $this->db = new \PDO(DSN, DB_USERNAME, DB_PASSWORD);
    } catch (\PDOException $e) {
      echo $e->getMessage();
      exit;
    }
  }
}
