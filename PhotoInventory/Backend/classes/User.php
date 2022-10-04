<?php
require_once "../../config/Database.php";

class User
{
  private $conn;
  private $table = "User";

  private $id;

  public function __construct()
  {
    $database = new Database();
    $db = $database->connect();
    $this->conn = $db;
  }
  //************************************************************* */
  //***** SET and GET User ID ***** */
  public function setUserID($userID)
  {
    $this->id = $userID;
  }
  public function getUserID()
  {
    return $this->id;
  }
  //************************************************************* */
  //***** Forget Password Token Reset ***** */
  //************************************************************* */
  //***** Check Token Valid ***** */
  public function checkTokenAlive($tokenKey)
  {
    $query =
      "SELECT UserID FROM PasswordToken WHERE ExpireTime > CURRENT_TIMESTAMP AND TokenKey = :tokenKey";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(":tokenKey", $tokenKey);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      $this->id = $row["UserID"];

      return true;
    } else {
      return false;
    }
  }
  //************************************************************* */
  //***** Check Token Valid ***** */
  public function deleteToken()
  {
    $query = "DELETE FROM PasswordToken WHERE UserID = :userID";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(":userID", $this->id);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
      return true;
    } else {
      return false;
    }
  }
  //************************************************************* */
  //***** Set Token in Data Base ***** */
  public function createToken($randomKey)
  {
    $query = "INSERT INTO PasswordToken (UserID, TokenKey) 
    VALUES (:id, :tokenKey)
    ON DUPLICATE KEY UPDATE TokenKey = :tokenKey";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(":id", $this->id);
    $stmt->bindParam(":tokenKey", $randomKey);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
      return true;
    } else {
      return false;
    }
  }
  //************************************************************* */
  //***** Check Email for Token ***** */
  public function checkEmailToken($email)
  {
    $query = "SELECT UserID FROM " . $this->table . " WHERE Email = :email";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(":email", $email);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      $this->id = $row["UserID"];
      return true;
    } else {
      return false;
    }
  }
  //************************************************************* */
  //***** User Profile / Login  ***** */
  //************************************************************* */
  //***** Login ***** */
  public function login($login, $password)
  {
    $query =
      "SELECT UserID FROM " .
      $this->table .
      " WHERE (Username = :login OR Email = :login) AND Password = :pass";

    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(":login", $login);
    $stmt->bindParam(":pass", $password);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      $this->id = $row["UserID"];
      return true;
    } else {
      return false;
    }
  }
  //************************************************************* */
  //***** CHECK Email Exists ***** */
  public function checkEmailExists($email)
  {
    $query = "SELECT UserID FROM " . $this->table . " WHERE Email = :email";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(":email", $email);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
      return true;
    } else {
      return false;
    }
  }

  //************************************************************* */
  //***** CHECK Username Exists ***** */
  public function checkUsernameExists($username)
  {
    $query =
      "SELECT UserID FROM " . $this->table . " WHERE Username = :username";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(":username", $username);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      $this->id = $row["UserID"];
      return true;
    } else {
      return false;
    }
  }
  //************************************************************* */
  //***** CHECK Old Password ***** */
  public function checkOldPassword($oldPassword)
  {
    $query =
      "SELECT UserID FROM " .
      $this->table .
      " WHERE UserID = :id AND Password = :oldpass";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(":id", $this->id);
    $stmt->bindParam(":oldpass", $oldPassword);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
      return true;
    } else {
      return false;
    }
  }
  //************************************************************* */
  //***** CREATE New User ***** */
  public function createNewUser($name, $username, $email, $password)
  {
    $query =
      "INSERT INTO User (FullName, Username, Email, Password) VALUES (:name, :username, :email, :password)";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(":name", $name);
    $stmt->bindParam(":username", $username);
    $stmt->bindParam(":email", $email);
    $stmt->bindParam(":password", $password);

    if ($stmt->execute()) {
      $query = "SELECT UserID FROM User WHERE Username = :username";
      $stmt = $this->conn->prepare($query);
      $stmt->bindParam(":username", $username);
      $stmt->execute();
      if ($stmt->rowCount() > 0) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->id = $row["UserID"];
        return true;
      } else {
        printf("Error: %s.\n", $stmt->error);
        return false;
      }
    }

    printf("Error: %s.\n", $stmt->error);
    return false;
  }

  //************************************************************* */
  //***** Edit User Profile ***** */
  //************************************************************* */
  //***** UPDATE Name ***** */
  public function updateName($fullname)
  {
    $query = "UPDATE User SET FullName = :fullname WHERE UserID = :id";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(":fullname", $fullname);
    $stmt->bindParam(":id", $this->id);

    if ($stmt->execute()) {
      return true;
    }
    printf("Error: %s.\n", $stmt->error);
    return false;
  }
  //************************************************************* */
  //***** UPDATE Username ***** */
  public function updateUsername($username)
  {
    $query = "UPDATE User SET Username = :username WHERE UserID = :id";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(":username", $username);
    $stmt->bindParam(":id", $this->id);

    if ($stmt->execute()) {
      return true;
    }

    printf("Error: %s.\n", $stmt->error);
    return false;
  }
  //************************************************************* */
  //***** UPDATE Email ***** */
  public function updateEmail($email)
  {
    $query = "UPDATE User SET Email = :email WHERE UserID = :id";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(":email", $email);
    $stmt->bindParam(":id", $this->id);

    if ($stmt->execute()) {
      return true;
    }
    printf("Error: %s.\n", $stmt->error);
    return false;
  }
  //************************************************************* */
  //***** UPDATE Password ***** */
  public function updatePassword($password)
  {
    $query = "UPDATE User SET Password = :password WHERE UserID = :id";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(":password", $password);
    $stmt->bindParam(":id", $this->id);

    if ($stmt->execute()) {
      return true;
    }
    printf("Error: %s.\n", $stmt->error);
    return false;
  }

  //************************************************************* */
  //***** UPDATE Unit ***** */
  public function updateUnit($unit)
  {
    $query = "UPDATE User SET UnitSystem = :unit WHERE UserID = :id";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(":unit", $unit);
    $stmt->bindParam(":id", $this->id);

    if ($stmt->execute()) {
      return true;
    }
    printf("Error: %s.\n", $stmt->error);
    return false;
  }

  //************************************************************* */
  //***** Get User Profile ***** */
  public function getUserProfile()
  {
    if ($this->id != 0) {
      $query = "SELECT * FROM User WHERE UserID = :id";
      $stmt = $this->conn->prepare($query);
      $stmt->bindParam(":id", $this->id);
      $stmt->execute();
      if ($stmt->rowCount() > 0) {
        $row = $stmt->fetch(PDO::FETCH_OBJ);
        // $json = json_encode($row);
        return $row;
      } else {
        printf("Error: %s.\n", $stmt->error);
        return 0;
      }
    } else {
      return 0;
    }
  }
}

?>
