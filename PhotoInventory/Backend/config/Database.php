<?php

class Database
{
  private $host = "localhost";
  private $db_name = "PhotoInventory";
  private $username = "root";
  private $password = "findroodpass";
  private $conn;

  public function connect()
  {
    $this->conn = null;

    // Set DSN (Data Source Name)
    $dsn = "mysql:host=" . $this->host . ";dbname=" . $this->db_name;

    try {
      $this->conn = new PDO($dsn, $this->username, $this->password);
      $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
      echo "Connection Error: " . $e->getMessage();
    }
    return $this->conn;
  }
}

?>
