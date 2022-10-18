<?php

require_once "../../config/Database.php";

class MainLocation
{
  private $conn;
  private $id;
  public $newMainID;
  public function __construct($userID)
  {
    $database = new Database();
    $db = $database->connect();
    $this->conn = $db;
    $this->id = $userID;
  }
  public function setUserID($userID)
  {
    $this->id;
  }
  public function getUserID()
  {
    return $this->id;
  }
  //************************************************************* */
  //***** Get Own Main Location ***** */
  public function getOwnMainLocation()
  {
    $query = "SELECT ML.*, COUNT(SL.MainlocationID) AS NumPeople 
    FROM MainLocation AS ML
    LEFT OUTER JOIN SharedLocation AS SL
    ON ML.MainLocationID = SL.MainLocationID
    WHERE ML.OwnerID = :id
    GROUP BY ML.MainLocationID";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(":id", $this->id);
    $stmt->execute();
    if ($stmt->rowcount() > 0) {
      $jsonArray = [];
      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        array_push($jsonArray, $row);
      }
      return json_encode($jsonArray);
    } elseif ($stmt->rowcount() == 0) {
      return json_encode("NO LOCATION");
    } else {
      printf("Error: %s.\n", $stmt->error);
    }
  }
  //************************************************************* */
  //***** Get Shared Main Location ***** */
  public function getShareMainLocation()
  {
    $query = "SELECT SL.MainLocationID, FullName, Username, Name, TotalLocation, TotalLayer, TotalObjectType, AccessType
    FROM SharedLocation AS SL 
    JOIN MainLocation AS ML ON ML.MainLocationID = SL.MainLocationID 
    JOIN User AS UR ON UR.UserID = ML.OwnerID
    WHERE SL.SharedUserID = :id";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(":id", $this->id);
    $stmt->execute();
    if ($stmt->rowcount() > 0) {
      $jsonArray = [];
      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        array_push($jsonArray, $row);
      }
      return json_encode($jsonArray);
    } elseif ($stmt->rowcount() == 0) {
      return json_encode("NO SHARE LOCATION");
    } else {
      printf("Error: %s.\n", $stmt->error);
    }
  }
  //************************************************************* */
  //***** Get Shared User from Main Location ***** */
  public function getSharedUser($mainID)
  {
    $query = "SELECT UR.UserID, UR.FullName, UR.Username, SL.AccessType
    FROM User AS UR
    INNER JOIN SharedLocation AS SL
    ON SL.SharedUserID = UR.UserID
    WHERE MainLocationId = :mainID
    AND (EXISTS (SELECT 1 FROM SharedLocation WHERE SharedUserID = :id AND MainLocationID = :mainID) 
    OR EXISTS (SELECT 1 FROM ObjectLibrary WHERE OwnerID = :id AND MainLocationID = :mainID))";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(":id", $this->id);
    $stmt->bindParam(":mainID", $mainID);
    $stmt->execute();
    if ($stmt->rowcount() > 0) {
      $jsonArray = [];
      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        array_push($jsonArray, $row);
      }
      return json_encode($jsonArray);
    } elseif ($stmt->rowcount() == 0) {
      return "NO Shared User Found or YOU don't Own Location!\n";
    } else {
      printf("Error: %s.\n", $stmt->error);
    }
  }
  //************************************************************* */
  //***** GET Owner of the Main Location ***** */
  public function getOwner($mainID)
  {
    $query = "SELECT UserID, FullName, Username 
    FROM User JOIN MainLocation ON OwnerID = UserID WHERE MainLocationID = :mainID
    AND (EXISTS (SELECT 1 FROM SharedLocation WHERE SharedUserID = :id AND MainLocationID = :mainID ) 
    OR EXISTS (SELECT 1 FROM MainLocation WHERE OwnerID = :id AND MainLocationID = :mainID))";

    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(":id", $this->id);
    $stmt->bindParam(":mainID", $mainID);
    $stmt->execute();
    if ($stmt->rowcount() > 0) {
      $jsonArray = [];
      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        array_push($jsonArray, $row);
      }
      return json_encode($jsonArray);
    } elseif ($stmt->rowcount() == 0) {
      echo "No OWNER Found!\n";
    } else {
      printf("Error: %s.\n", $stmt->error);
    }
  }
  //************************************************************** */
  //****** CHECK Main Location Owner TRUE/FALSE */
  public function checkOwner($mainID)
  {
    $query =
      "SELECT 1 FROM MainLocation WHERE OwnerID = :id AND MainLocationID = :mainID";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(":id", $this->id);
    $stmt->bindParam(":mainID", $mainID);
    $stmt->execute();
    if ($stmt->rowcount() > 0) {
      // echo "Yout Own this Main Location..\n";
      return true;
    } elseif ($stmt->rowcount() == 0) {
      // echo "YOU DON'T OWN THIS MAIN LOCATION!!!\n";
      return false;
    } else {
      printf("Error: %s.\n", $stmt->error);
    }
  }

  //************************************************************** */
  //****** CHECK Name of a Main Location By Owner */
  public function checkMainName($name)
  {
    $query = "SELECT 1 FROM Mainlocation WHERE OwnerID = :id AND Name = :name";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(":id", $this->id);
    $stmt->bindParam(":name", $name);
    $stmt->execute();
    if ($stmt->rowcount() > 0) {
      echo "THER NAME ALREADY EXISTS!!!\n";
      return true;
    } elseif ($stmt->rowcount() == 0) {
      // echo "The Name is NOT Used...\n";
      return false;
    } else {
      printf("Error: %s.\n", $stmt->error);
    }
  }

  //************************************************************** */
  //****** CHECK Shared User Access Type */
  public function checkShareUserAccess($mainID, $access)
  {
    $query = "SELECT 1 FROM SharedLocation 
    WHERE SharedUserID = :id AND MainLocationID = :mainID AND AccessType >= :access";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(":id", $this->id);
    $stmt->bindParam(":mainID", $mainID);
    $stmt->bindParam(":access", $access);

    $stmt->execute();
    if ($stmt->rowcount() > 0) {
      echo "User Have Access: " . $access . " To this Main Location\n";
      return true;
    } elseif ($stmt->rowcount() == 0) {
      echo "ACCESS DENIED\n";
      return false;
    } else {
      printf("Error: %s.\n", $stmt->error);
    }
  }

  //************************************************************** */
  //****** CHECK Shared User Access Type */
  public function addNewMain($name)
  {
    if ($this->checkMainName($name)) {
      return false;
    } else {
      $query = "INSERT INTO MainLocation(OwnerID, Name) VALUES(:id, :name)";
      $stmt = $this->conn->prepare($query);
      $stmt->bindParam(":id", $this->id);
      $stmt->bindParam(":name", $name);

      $stmt->execute();
      if ($stmt->rowcount() > 0) {
        $this->newMainID = $this->getNewMainID();
        echo json_encode("ADD");
        return true;
      } elseif ($stmt->rowcount() == 0) {
        echo json_encode("FAIL");
        return false;
      } else {
        printf("Error: %s.\n", $stmt->error);
      }
    }
  }
  //************************************************************** */
  //****** UPDATE|EDIT Main Location */
  public function updateMain($mainID, $name)
  {
    if ($this->checkMainName($name)) {
      return false;
    } else {
      $query =
        "UPDATE MainLocation SET Name = :name WHERE MainLocationID = :mainID AND OwnerID = :id";
      $stmt = $this->conn->prepare($query);
      $stmt->bindParam(":id", $this->id);
      $stmt->bindParam(":mainID", $mainID);
      $stmt->bindParam(":name", $name);

      $stmt->execute();
      if ($stmt->rowcount() > 0) {
        echo json_encode("UPDATED");
        return true;
      } elseif ($stmt->rowcount() == 0) {
        echo json_encode("FAIL");
        return false;
      } else {
        printf("Error: %s.\n", $stmt->error);
      }
    }
  }
  //************************************************************** */
  //****** SHARE|UPDATE|INSER|EDIT User to a Main Location*/
  public function shareMainLocation($mainID, $shareID, $access)
  {
    $query = "INSERT INTO SharedLocation(MainLocationID, SharedUserID, AccessType) 
    (SELECT :mainID, :shareID, :access 
    WHERE EXISTS (SELECT 1 FROM Connection WHERE (UserB = :id OR UserA = :id) AND (UserA = :shareID OR UserB = :shareID) AND Status = 1)
    AND EXISTS (SELECT 1 FROM MainLocation WHERE OwnerID = :id AND MainLocationID = :mainID))
    ON DUPLICATE KEY UPDATE AccessType = :access";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(":id", $this->id);
    $stmt->bindParam(":mainID", $mainID);
    $stmt->bindParam(":shareID", $shareID);
    $stmt->bindParam(":access", $access);
    $stmt->execute();
    if ($stmt->rowcount() > 0) {
      echo json_encode("SHARED");
      return true;
    } elseif ($stmt->rowcount() == 0) {
      echo json_encode("FAIL");
      return false;
    } else {
      printf("Error: %s.\n", $stmt->error);
    }
  }
  //************************************************************** */
  //****** LEAVE | DELETE Shared Main Location */
  public function leaveSharedMainLocation($mainID)
  {
    $query =
      "DELETE FROM SharedLocation WHERE MainLocationID = :mainID AND SharedUserID = :id";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(":id", $this->id);
    $stmt->bindParam(":mainID", $mainID);

    $stmt->execute();
    if ($stmt->rowcount() > 0) {
      echo json_encode("LEAVE");
      return true;
    } elseif ($stmt->rowcount() == 0) {
      echo json_encode("FAIL");
      return false;
    } else {
      printf("Error: %s.\n", $stmt->error);
    }
  }
  //************************************************************** */
  //****** REMOVE | DELETE Shared User from Own Main Location */
  public function removeShareUser($mainID, $shareID)
  {
    $query = "DELETE FROM SharedLocation WHERE MainLocationID = :mainID AND SharedUserID = :shareID
    AND EXISTS (SELECT 1 FROM MainLocation WHERE OwnerID = :id AND MainLocationID = :mainID);";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(":id", $this->id);
    $stmt->bindParam(":mainID", $mainID);
    $stmt->bindParam(":shareID", $shareID);

    $stmt->execute();
    if ($stmt->rowcount() > 0) {
      echo json_encode("REMOVE");
      return true;
    } elseif ($stmt->rowcount() == 0) {
      echo json_encode("FAIL");
      return false;
    } else {
      printf("Error: %s.\n", $stmt->error);
    }
  }

  //************************************************************** */
  //****** DELETE Own Main Location */
  public function deleteMainLocation($mainID, $name)
  {
    $query =
      "DELETE FROM MainLocation WHERE MainLocationID = :mainID AND OwnerID = :id AND Name = :name";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(":id", $this->id);
    $stmt->bindParam(":mainID", $mainID);
    $stmt->bindParam(":name", $name);

    $stmt->execute();
    if ($stmt->rowcount() > 0) {
      echo json_encode("DELETED");
      return true;
    } elseif ($stmt->rowcount() == 0) {
      echo json_encode("FAIL");
      return false;
    } else {
      printf("Error: %s.\n", $stmt->error);
    }
  }

  //************************************************************** */
  //****** GET New Main ID ***** */
  public function getNewMainID()
  {
    $query =
      "SELECT MAX(MainLocationID) AS NewMain FROM MainLocation WHERE OwnerID = :id";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(":id", $this->id);

    $stmt->execute();
    if ($stmt->rowcount() > 0) {
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      return $row["NewMain"];
    } elseif ($stmt->rowcount() == 0) {
      echo "CAN'T FIND NEW MAX ID!!!\n";
      return false;
    } else {
      printf("Error: %s.\n", $stmt->error);
    }
  }

  //************************************************************* */
  //***** GET New Users To Add To Library in Here ***** */
  public function getNewUser($mainID)
  {
    $query = "SELECT FullName, Username, UserID FROM User 
    JOIN Connection ON (UserID = UserA  OR UserID = UserB) 
    AND UserID != :id WHERE (UserA = :id OR UserB = :id) AND Status = 1
    AND UserID NOT IN (SELECT SharedUserID FROM SharedLocation WHERE MainLocationID = :mainID)";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(":id", $this->id);
    $stmt->bindParam(":mainID", $mainID);
    $stmt->execute();
    if ($stmt->rowcount() > 0) {
      $jsonArray = [];
      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        array_push($jsonArray, $row);
      }
      return json_encode($jsonArray);
    } elseif ($stmt->rowcount() == 0) {
      return json_encode("NO USER");
    } else {
      printf("Error: %s.\n", $stmt->error);
    }
  }

  //************************************************************** */
  //****** GET SHARE Main Location Information  ***** */
  public function getShareMainInfo($mainID)
  {
    $query = "SELECT Name, TotalLocation, TotalObjectType, FullName, Username, AccessType
    FROM MainLocation AS ML JOIN User ON OwnerID = UserID
    JOIN SharedLocation AS SL ON ML.MainLocationID = SL.MainLocationID
    WHERE ML.MainLocationID = :mainID AND SL.SharedUserID = :id";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(":id", $this->id);
    $stmt->bindParam(":mainID", $mainID);
    $stmt->execute();

    if ($stmt->rowcount() > 0) {
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      return json_encode($row);
    } elseif ($stmt->rowcount() == 0) {
      echo json_encode("DENY");
    } else {
      printf("Error: %s.\n", $stmt->error);
    }
  }
  //************************************************************** */
  //****** GET own Main Location Information ***** */
  public function getOwnMainInfo($mainID)
  {
    $query = "SELECT Name, TotalLocation, TotalObjectType 
    FROM MainLocation WHERE OwnerID = :id AND MainLocationID = :mainID";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(":id", $this->id);
    $stmt->bindParam(":mainID", $mainID);
    $stmt->execute();

    if ($stmt->rowcount() > 0) {
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      return json_encode($row);
    } elseif ($stmt->rowcount() == 0) {
      echo json_encode("DENY");
    } else {
      printf("Error: %s.\n", $stmt->error);
    }
  }

  //Add Function Above this Line
} // End of Class

?>
