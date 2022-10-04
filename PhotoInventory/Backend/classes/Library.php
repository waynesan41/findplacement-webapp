<?php

require_once "../../config/Database.php";

class Library
{
  private $conn;
  private $id;
  public $newLibID = null;

  public function __construct($userID)
  {
    $database = new Database();
    $db = $database->connect();
    $this->conn = $db;
    $this->id = $userID;
  }

  public function setUserID($userID)
  {
    $this->id = $userID;
  }
  public function getUserID()
  {
    return $this->id;
  }
  //************************************************************* */
  //***** Get Own Library ***** */
  public function getOwnLibrary()
  {
    $query = "SELECT OL.LibraryID, OL.Name, OL.TotalObject, COUNT(SL.ObjectLibraryID) as NumPeople
      FROM ObjectLibrary AS OL 
      LEFT OUTER JOIN SharedLibrary AS SL
      ON SL.ObjectLibraryID = OL.LibraryID
      WHERE OwnerID = :id
      GROUP BY OL.LibraryID";

    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(":id", $this->id);
    $stmt->execute();
    if ($stmt->rowcount() > 0) {
      $jsonArray = [];
      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        array_push($jsonArray, $row);
      }
      echo json_encode($jsonArray);
      return true;
    } elseif ($stmt->rowcount() == 0) {
      echo json_encode("NO LIBRARY");
      return false;
    } else {
      printf("Error: %s.\n", $stmt->error);
    }
  }
  //************************************************************* */
  //***** Get Shared Library ***** */
  public function getSharedLibrary()
  {
    $query = "SELECT SL.ObjectLibraryID, OL.Name, SL.AccessType, UR.FullName AS OwnerName, UR.Username AS OwnerUsername, OL.TotalObject
      FROM SharedLibrary AS SL
      LEFT OUTER JOIN ObjectLibrary AS OL
      ON SL.ObjectLibraryID = OL.LibraryID
      LEFT OUTER JOIN User AS UR
      ON OL.OwnerID = UR.UserID
      WHERE SharedUserID = :id";

    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(":id", $this->id);
    $stmt->execute();
    if ($stmt->rowcount() > 0) {
      $jsonArray = [];
      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        array_push($jsonArray, $row);
      }
      echo json_encode($jsonArray);
      return true;
    } elseif ($stmt->rowcount() == 0) {
      echo json_encode("NO LIBRARY");
      return false;
    } else {
      printf("Error: %s.\n", $stmt->error);
    }
  }
  //************************************************************* */
  //***** GET Shared Users from a Library ***** */
  public function getSharedUsers($libraryID)
  {
    $query = "SELECT UR.UserID, UR.FullName, UR.Username, SL.AccessType
    FROM User AS UR
    INNER JOIN SharedLibrary AS SL
    ON SL.SharedUserID = UR.UserID
    WHERE ObjectLibraryID = :libraryID
    AND (EXISTS (SELECT 1 FROM SharedLibrary WHERE SharedUserID = :id AND ObjectLibraryID = :libraryID) 
    OR EXISTS (SELECT 1 FROM ObjectLibrary WHERE OwnerID = :id AND LibraryID = :libraryID))";

    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(":id", $this->id);
    $stmt->bindParam(":libraryID", $libraryID);
    $stmt->execute();
    if ($stmt->rowcount() > 0) {
      $jsonArray = [];
      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        array_push($jsonArray, $row);
      }
      return json_encode($jsonArray);
    } elseif ($stmt->rowcount() == 0) {
      echo json_encode("NO USER");
    } else {
      printf("Error: %s.\n", $stmt->error);
    }
  }

  //************************************************************* */
  //***** GET Owner of a Library ***** */
  public function getOwner($libraryID)
  {
    $query = "SELECT UserID, FullName, Username 
    FROM User JOIN ObjectLibrary ON OwnerID = UserID WHERE LibraryID = :libraryID
    AND (EXISTS (SELECT 1 FROM SharedLibrary WHERE SharedUserID = :id AND ObjectLibraryID = :libraryID ) 
    OR EXISTS (SELECT 1 FROM ObjectLibrary WHERE OwnerID = :id AND LibraryID = :libraryID))";

    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(":id", $this->id);
    $stmt->bindParam(":libraryID", $libraryID);
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
  //=========================================== /
  // CHECK Library
  //=========================================== /
  //******************************************* */
  // Check Library Name
  public function checkLibraryName($libraryName)
  {
    $query =
      "SELECT 1 FROM ObjectLibrary WHERE Name = :libraryName AND OwnerID = :id";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(":id", $this->id);
    $stmt->bindParam(":libraryName", $libraryName);
    $stmt->execute();
    if ($stmt->rowcount() > 0) {
      return true;
    } elseif ($stmt->rowcount() == 0) {
      return false;
    } else {
      printf("Error: %s.\n", $stmt->error);
    }
  }
  //=========================================== /
  // UPDATE / INSERT Library
  //=========================================== /

  //******************************************* */
  // Update Library
  public function updateLibrary($libraryID, $name)
  {
    $query =
      "UPDATE ObjectLibrary SET name = :name WHERE LibraryId = :libraryID AND OwnerID = :id";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(":id", $this->id);
    $stmt->bindParam(":libraryID", $libraryID);
    $stmt->bindParam(":name", $name);
    $stmt->execute();
    if ($stmt->rowcount() > 0) {
      echo json_encode("UPDATED");
    } elseif ($stmt->rowcount() == 0) {
      echo json_encode("FAIL");
    } else {
      printf("Error: %s.\n", $stmt->error);
    }
  }
  //******************************************* */
  // ADD New Library
  public function addLibrary($libraryName)
  {
    if ($this->checkLibraryName($libraryName)) {
      echo "Library Name Already Exists!";
    } else {
      $query =
        "INSERT INTO ObjectLibrary (OwnerID, Name) VALUES (:id, :libraryName)";
      $stmt = $this->conn->prepare($query);
      $stmt->bindParam(":id", $this->id);
      $stmt->bindParam("libraryName", $libraryName);
      $stmt->execute();
      if ($stmt->rowcount() > 0) {
        echo json_encode("ADD");
        $this->newLibID = $this->getNewLibID();
        return true;
      } elseif ($stmt->rowcount() == 0) {
        echo json_encode("FAIL");
        return false;
      } else {
        printf("Error: %s.\n", $stmt->error);
      }
    }
  }
  //******************************************* */
  // Share Library with Connected User
  public function shareLibrary($libraryID, $shareID, $access)
  {
    $query = "INSERT INTO SharedLibrary (ObjectLibraryID, SharedUserID, AccessType) (SELECT :libraryID, :shareID, :access
    WHERE EXISTS (SELECT 1 FROM Connection WHERE (UserB = :id OR UserA = :id) AND (UserA = :shareID OR UserB = :shareID) AND Status = 1)
    AND EXISTS (SELECT 1 FROM ObjectLibrary WHERE OwnerID = :id AND LibraryID = :libraryID))
    ON DUPLICATE KEY UPDATE AccessType = :access";

    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(":id", $this->id);
    $stmt->bindParam(":libraryID", $libraryID);
    $stmt->bindParam(":shareID", $shareID);
    $stmt->bindParam(":access", $access);
    $stmt->execute();
    if ($stmt->rowcount() > 0) {
      echo json_encode("UPDATED");
    } elseif ($stmt->rowcount() == 0) {
      echo json_encode("FAIL");
    } else {
      printf("Error: %s.\n", $stmt->error);
    }
  }

  //******************************************* */
  // REMOVE User from Shared Library
  public function removeShareUser($libraryID, $shareID)
  {
    $query = "DELETE FROM SharedLibrary WHERE ObjectLibraryID = :libraryID AND SharedUserID = :shareID
    AND EXISTS (SELECT * FROM ObjectLibrary WHERE OwnerID = :id AND LibraryID = :libraryID)";

    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(":id", $this->id);
    $stmt->bindParam(":shareID", $shareID);
    $stmt->bindParam(":libraryID", $libraryID);
    $stmt->execute();
    if ($stmt->rowcount() > 0) {
      echo json_encode("REMOVE");
    } elseif ($stmt->rowcount() == 0) {
      echo json_encode("FAIL");
    } else {
      printf("Error: %s.\n", $stmt->error);
    }
  }

  //******************************************* */
  // LEAVE Share Library
  public function leaveShareLibrary($libraryID)
  {
    $query =
      "DELETE FROM SharedLibrary WHERE ObjectLibraryID = :libraryID AND SharedUserID = :id";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(":id", $this->id);
    $stmt->bindParam(":libraryID", $libraryID);
    $stmt->execute();
    if ($stmt->rowcount() > 0) {
      echo json_encode("LEAVE");
    } elseif ($stmt->rowcount() == 0) {
      echo json_encode("FAIL");
    } else {
      printf("Error: %s.\n", $stmt->error);
    }
  }

  //******************************************* */
  // DELETE Owned Library
  public function deleteOwnLibrary($libraryID, $libraryName)
  {
    $query =
      "DELETE FROM ObjectLibrary WHERE OwnerID = :id AND LibraryID = :libraryID AND Name = :libraryName";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(":id", $this->id);
    $stmt->bindParam(":libraryID", $libraryID);
    $stmt->bindParam(":libraryName", $libraryName);
    $stmt->execute();
    if ($stmt->rowcount() > 0) {
      echo json_encode("DELETED");
    } elseif ($stmt->rowcount() == 0) {
      echo json_encode("FAIL");
    } else {
      printf("Error: %s.\n", $stmt->error);
    }
  }

  //******************************************* */
  // GET New Users to ADD
  public function getNewUser($libraryID)
  {
    $query = "SELECT FullName, Username, UserID FROM User 
    JOIN Connection ON (UserID = UserA  OR UserID = UserB) 
    AND UserID != :id WHERE (UserA = :id OR UserB = :id) AND Status = 1
    AND UserID NOT IN (SELECT SharedUserID FROM SharedLibrary WHERE ObjectLibraryID = :libraryID)";

    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(":id", $this->id);
    $stmt->bindParam(":libraryID", $libraryID);
    $stmt->execute();
    if ($stmt->rowcount() > 0) {
      $jsonArray = [];
      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        array_push($jsonArray, $row);
      }
      return json_encode($jsonArray);
    } elseif ($stmt->rowcount() == 0) {
      echo json_encode("NO USER");
    } else {
      printf("Error: %s.\n", $stmt->error);
    }
  }

  //************************************************************** */
  //****** GET New Lib ID ***** */
  public function getNewLibID()
  {
    $query =
      "SELECT MAX(LibraryID) AS NewLib FROM ObjectLibrary WHERE OwnerID = :id";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(":id", $this->id);

    $stmt->execute();
    if ($stmt->rowcount() > 0) {
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      return $row["NewLib"];
    } elseif ($stmt->rowcount() == 0) {
      echo "CAN'T FIND NEW MAX LIBRARY ID!!!\n";
      return false;
    } else {
      printf("Error: %s.\n", $stmt->error);
    }
  }

  //************************************************************** */
  //****** GET Share Library Information ***** */
  public function getShareLibraryInfo($libraryID)
  {
    $query = "SELECT Name, TotalObject, FullName, Username 
      FROM ObjectLibrary JOIN User ON OwnerID = UserID 
      JOIN SharedLibrary ON ObjectLibraryID = LibraryID
      WHERE LibraryID = :libraryID AND SharedUserID = :id";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(":id", $this->id);
    $stmt->bindParam(":libraryID", $libraryID);
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
  //****** GET OWN Library Information ***** */
  public function getOwnLibraryInfo($libraryID)
  {
    $query = "SELECT Name, TotalObject FROM ObjectLibrary 
      WHERE OwnerID = :id AND LibraryID = :libraryID";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(":id", $this->id);
    $stmt->bindParam(":libraryID", $libraryID);
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
  //****** CHECK Main Location Owner TRUE/FALSE */
  public function checkOwner($libraryID)
  {
    $query =
      "SELECT * FROM ObjectLibrary WHERE LibraryID = :libraryID AND OwnerID = :id";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(":id", $this->id);
    $stmt->bindParam(":libraryID", $libraryID);
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
  //****** CHECK Shared User Access Type Library */
  public function checkAccess($libraryID, $access)
  {
    $query = "SELECT * FROM SharedLibrary 
      WHERE ObjectLibraryID = :libraryID AND SharedUserID = :id";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(":id", $this->id);
    $stmt->bindParam(":libraryID", $libraryID);

    $stmt->execute();
    if ($stmt->rowcount() > 0) {
      // echo "User Have Access: " . $access . " To this Main Location\n";
      return true;
    } elseif ($stmt->rowcount() == 0) {
      // echo "ACCESS DENIED\n";
      return false;
    } else {
      printf("Error: %s.\n", $stmt->error);
    }
  }
}

?>
