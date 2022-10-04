<?php
include_once "../../config/Database.php";

class Connection
{
  private $conn;
  private $id;

  public function __construct()
  {
    $database = new Database();
    $db = $database->connect();
    $this->conn = $db;
  }
  public function setUserID($userID)
  {
    $this->id = $userID;
  }
  public function getUserID()
  {
    return $this->id;
  }
  //******************************************* */
  // Search User By Username
  //******************************************* */
  public function searchUser($search)
  {
    $query = "SELECT UserID, FullName, Username 
      FROM User 
      WHERE Username LIKE :searchKey 
      AND UserID NOT IN 
      (SELECT UserA 
      FROM Connection WHERE UserB = :id AND Status = 2 
      UNION 
      SELECT UserB FROM Connection WHERE UserA = :id AND Status = 2 UNION SELECT :id) LIMIT 30";

    $stmt = $this->conn->prepare($query);
    $search = "%" . $search . "%";
    $stmt->bindParam(":searchKey", $search);
    $stmt->bindParam(":id", $this->id);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
      $jsonArray = [];
      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        array_push($jsonArray, $row);
      }
      echo json_encode($jsonArray);
    } elseif ($stmt->rowCount() == 0) {
      echo json_encode("NO USER");
    } else {
      printf("Error: %s.\n", $stmt->error);
      return "Query ERROR!";
    }
  }

  //**************************************** */
  // Get Request To
  //**************************************** */
  public function getUserRequestTo()
  {
    $query = "SELECT FullName, Username, UserID
    FROM User JOIN Connection ON UserB = UserID WHERE UserA = :id AND Status = 0";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(":id", $this->id);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
      $jsonArray = [];
      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        array_push($jsonArray, $row);
      }
      return json_encode($jsonArray);
    } elseif ($stmt->rowCount() == 0) {
      return json_encode("NO USER");
    } else {
      printf("Error: %s\n", $stmt->error);
      return "No User Found!\n";
    }
  }

  //**************************************** */
  // Get Request From
  //**************************************** */
  public function getRequestFromUser()
  {
    $query = "SELECT FullName, Username, UserID
    FROM User JOIN Connection ON UserA = UserID WHERE UserB = :id AND Status = 0";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(":id", $this->id);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
      $jsonArray = [];
      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        array_push($jsonArray, $row);
      }
      return json_encode($jsonArray);
    } elseif ($stmt->rowCount() == 0) {
      return json_encode("NO USER");
    } else {
      printf("Error: %s\n", $stmt->error);
      return json_encode("ERROR");
    }
  }
  //*************************************** */
  // Get All Connections
  //*************************************** */
  public function getConnectedUser()
  {
    $query = "SELECT FullName, Username, UserID FROM User 
      JOIN Connection ON (UserID = UserA  OR UserID = UserB) AND UserID != :id
      WHERE (UserA = :id OR UserB = :id) AND Status = 1 GROUP BY UserID";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(":id", $this->id);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
      $jsonArray = [];
      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        array_push($jsonArray, $row);
      }
      return json_encode($jsonArray);
    } elseif ($stmt->rowCount() == 0) {
      return json_encode("NO USER");
    } else {
      printf("Error: %s\n", $stmt->error);
      return "Query ERROR!\n";
    }
  }

  //*************************************** */
  // Get Blocked Users
  //*************************************** */
  public function getBlockedUser()
  {
    $query = "SELECT FullName, Username, UserID
    FROM User JOIN Connection ON UserB = UserID WHERE UserA = :id AND Status = 2";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(":id", $this->id);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
      $jsonArray = [];
      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        array_push($jsonArray, $row);
      }
      return json_encode($jsonArray);
    } elseif ($stmt->rowCount() == 0) {
      return json_encode("NO USER");
    } else {
      printf("Error: %s\n", $stmt->error);
      return "Query ERROR!\n";
    }
  }

  //==========================================//
  //======== CHECK Functions =================//
  //==========================================//
  //****************************************** */
  // Check If the UserID Blocked You
  //****************************************** */
  public function checkBlocked($blockID)
  {
    $query = "SELECT * FROM Connection 
      WHERE ((UserA = :id AND UserB = :blockID) OR (UserA = :blockID AND UserB = :id)) AND Status = 2";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(":id", $this->id);
    $stmt->bindParam(":blockID", $blockID);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
      return true;
    } else {
      return false;
    }
  }
  //********************************* */
  // Check User is ALready Connected
  //********************************* */
  public function checkConnected($connectedID)
  {
    $query = "SELECT * FROM Connection 
      WHERE (UserB = :id OR UserA = :id) 
      AND (UserA = :connectedID OR UserB = :connectedID) AND Status = 1";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(":id", $this->id);
    $stmt->bindParam(":connectedID", $connectedID);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
      return true;
    } else {
      return false;
    }
  }
  //*********************************** */
  // Check User is Requested to you
  //*********************************** */
  public function checkRequestFrom($requesterID)
  {
    $query =
      "SELECT * FROM Connection WHERE UserA = :requesterID AND UserB = :id AND Status = 0";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(":id", $this->id);
    $stmt->bindParam(":requesterID", $requesterID);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
      return true;
    } else {
      return false;
    }
  }
  //*********************************** */
  // Check User is Requested to you
  //*********************************** */
  public function checkRequestTo($requestID)
  {
    $query =
      "SELECT * FROM Connection WHERE UserA = :id AND UserB = :requestID AND Status = 0";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(":id", $this->id);
    $stmt->bindParam(":requestID", $requestID);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
      return true;
    } else {
      return false;
    }
  }

  //==========================================//
  //======== UPDATE/INSERT Session ===========//
  //==========================================//

  //************************************** */
  // UPDATE/INSERT SEND Request To
  //************************************** */
  public function sendRequestTo($userID)
  {
    if (
      !$this->checkBlocked($userID) &&
      !$this->checkConnected($userID) &&
      !$this->checkRequestTo($userID) &&
      !$this->checkRequestFrom($userID)
    ) {
      $query =
        "INSERT INTO Connection (UserA, UserB, Status) VALUES(:id, :receiverID, 0) ON DUPLICATE KEY UPDATE Status = 0";
      $stmt = $this->conn->prepare($query);
      $stmt->bindParam(":id", $this->id);
      $stmt->bindParam(":receiverID", $userID);
      $stmt->execute();
      if ($stmt->rowCount() > 0) {
        echo json_encode("SEND");
        return true;
      } else {
        echo json_encode("FAIL");
        return false;
      }
    } else {
      echo json_encode("FAIL");
      return false;
    }
  }

  //************************************** */
  // UPDATE ACCEPT Request From
  //************************************** */
  public function acceptRequestFrom($acceptID)
  {
    $query =
      "UPDATE Connection SET Status = 1 WHERE UserA = :acceptID AND UserB = :id  AND Status = 0";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(":id", $this->id);
    $stmt->bindParam(":acceptID", $acceptID);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
      echo json_encode("ACCEPT");
      return true;
    } else {
      echo json_encode("FAIL");
      return false;
    }
  }

  //**************************************** */
  // UPDATE DENY Request From
  //**************************************** */
  public function denyRequestFrom($denyID)
  {
    $query =
      "DELETE FROM Connection WHERE UserA = :denyID AND UserB = :id AND Status = 0";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(":id", $this->id);
    $stmt->bindParam(":denyID", $denyID);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
      echo json_encode("DENY");
      return true;
    } else {
      echo json_encode("FAIL");
      return false;
    }
  }
  //**************************************** */
  // UPDATE CANCEL Request To
  //**************************************** */
  public function cancelRequestTo($cancelID)
  {
    $query =
      "DELETE FROM Connection WHERE UserA = :id AND UserB = :cancelID AND Status = 0";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(":id", $this->id);
    $stmt->bindParam(":cancelID", $cancelID);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
      echo json_encode("CANCEL");
      return true;
    } else {
      echo json_encode("FAIL");
      return false;
    }
  }
  //**************************************** */
  // UPDATE DISCONNECT Request To
  //**************************************** */
  public function removeConnection($dcID)
  {
    $query = "DELETE FROM Connection 
      WHERE (UserA = :id AND UserB = :dcID AND Status != 2) OR (UserA = :dcID AND UserB = :id AND Status != 2)";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(":id", $this->id);
    $stmt->bindParam(":dcID", $dcID);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
      echo json_encode("DISCONNECT");
      return true;
    } elseif ($stmt->rowCount() == 0) {
      echo json_encode("FAIL");
      return false;
    } else {
      echo json_encode("ERROR");
      return false;
    }
  }

  //**************************************** */
  // UPDATE BLOCK User
  //**************************************** */
  public function blockUser($blockID)
  {
    if (!$this->checkBlocked($blockID)) {
      $query1 = "DELETE FROM Connection 
      WHERE (UserA = :id AND UserB = :blockID AND Status != 2) OR (UserA = :blockID AND UserB = :id AND Status != 2)";
      $stmt = $this->conn->prepare($query1);
      $stmt->bindParam(":id", $this->id);
      $stmt->bindParam(":blockID", $blockID);
      $stmt->execute();
      if ($stmt->rowCount() > 0) {
        //DELETE Existing Row
        // echo "DELETEs Preexisting Row";
      } else {
        //NO PreExisting Row Found
        // echo "No Preexisting ROW Found";
      }
      $query2 =
        "INSERT INTO Connection (UserA, UserB, Status) VALUES(:id, :blockID, 2)";
      $stmt = $this->conn->prepare($query2);
      $stmt->bindParam(":id", $this->id);
      $stmt->bindParam(":blockID", $blockID);
      $stmt->execute();
      if ($stmt->rowCount() > 0) {
        echo json_encode("BLOCK");
      } else {
        echo json_encode("FAIL");
      }
      return true;
    } else {
      echo json_encode("FAIL");
      return false;
    }
  }
  //**************************************** */
  // UN-BLOCK User
  //**************************************** */
  public function unblockUser($unblockID)
  {
    $query = "DELETE FROM Connection 
    WHERE UserA = :id AND UserB = :unBlockID AND Status = 2";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(":id", $this->id);
    $stmt->bindParam(":unBlockID", $unblockID);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
      echo json_encode("UNBLICK");
      return true;
    } else {
      echo json_encode("FAIL");
      return false;
    }
  }

  //**************************************** */
  // CHECK USER ON SEARCH
  //**************************************** */
  public function checkSearchUser($searchID)
  {
    $query = "SELECT * FROM Connection 
    WHERE (UserB = :id OR UserA = :id) 
    AND (UserA = :searchID OR UserB = :searchID)";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(":id", $this->id);
    $stmt->bindParam(":searchID", $searchID);
    $stmt->execute();
    if ($stmt->rowCount() == 0) {
      echo json_encode("N");
    } elseif ($stmt->rowCount() == 1) {
      $row = $stmt->fetch(PDO::FETCH_ASSOC);

      if ($row["Status"] == 1) {
        echo json_encode("C");
      } elseif ($row["Status"] == 0) {
        if ($row["UserA"] == $searchID) {
          echo json_encode("F");
        } else {
          echo json_encode("T");
        }
      }
    } else {
      echo json_encode("FAIL");
    }
  }
}
