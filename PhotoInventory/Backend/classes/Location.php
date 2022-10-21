<?php

include_once "../../config/Database.php";

class Location
{
  private $conn;
  private $id;
  public $newLocID;

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
  //***** Get Location inside the Main ***** */
  public function getLocation($mainID, $topID)
  {
    $query2 = "";
    if ($topID == 0) {
      $query2 = " IS NULL";
    } else {
      $query2 = " = :topID";
    }
    $query =
      "SELECT LO.* FROM Location AS LO 
      LEFT JOIN MainLocation AS ML ON  ML.MainLocationID = LO.MainLocationID
      LEFT JOIN SharedLocation AS SL ON SL.MainLocationID = LO.MainLocationID 
      WHERE LO.MainLocationID = :mainID AND TopLocationID " .
      $query2 .
      " AND (ML.OwnerID = :id OR SL.SharedUserID = :id)
      GROUP BY LO.LocationID";
    // echo "QUERY: " . $query . "\n";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(":id", $this->id);
    $stmt->bindParam(":mainID", $mainID);
    if ($topID != 0) {
      $stmt->bindParam(":topID", $topID);
    }
    $stmt->execute();
    if ($stmt->rowcount() > 0) {
      $jsonArray = [];
      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        array_push($jsonArray, $row);
      }
      return json_encode($jsonArray);
    } elseif ($stmt->rowcount() == 0) {
      echo json_encode("FAIL");
    } else {
      printf("Error: %s.\n", $stmt->error);
    }
  }

  //************************************************************* */
  //***** GET Location Information ***** */
  public function getLocationInfo($mainID, $locationID)
  {
    $query = "SELECT LO.* FROM Location AS LO
    LEFT JOIN SharedLocation AS SL ON SL.MainLocationID = LO.MainLocationID
    LEFT JOIN MainLocation AS ML ON ML.MainLocationID = LO.MainLocationID
    WHERE LO.MainLocationID = :mainID AND LocationID = :locationID 
    AND (OwnerID = :id OR SharedUserID = :id)";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(":id", $this->id);
    $stmt->bindParam(":mainID", $mainID);
    $stmt->bindParam(":locationID", $locationID);
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

  //************************************************************* */
  //***** ADD New Location Any Teir ***** */
  public function addNewLocation($mainID, $topID, $name, $locArr)
  {
    if (!$this->checkTopExists($mainID, $topID) && $topID != 0) {
      echo json_encode("INVALID7");
      return false;
    }
    $photoQuery = ["", ""];
    $descriptionQuery = ["", ""];

    if ($topID == 0) {
      $topID = null;
    }
    if (array_key_exists(":description", $locArr)) {
      $descriptionQuery[0] = ", Description";
      $descriptionQuery[1] = ", :description";
    }
    if (array_key_exists(":photo", $locArr)) {
      $photoQuery[0] = ", Photo";
      $photoQuery[1] = ", :photo";
    }
    $query =
      "INSERT INTO Location(LocationID, MainLocationID,  TopLocationID, Name" .
      $photoQuery[0] .
      $descriptionQuery[0] .
      ")
      VALUES(NULL, :mainID, :topID, :name" .
      $photoQuery[1] .
      $descriptionQuery[1] .
      ")";

    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(":mainID", $mainID);
    $stmt->bindParam(":topID", $topID);
    $stmt->bindParam(":name", $name);
    foreach ($locArr as $key => $value) {
      $stmt->bindValue($key, $value); // Bug in bindParam use bindValue
    }
    $stmt->execute();
    if ($stmt->rowcount() > 0) {
      echo json_encode("ADD");
      $this->getNewLocID($mainID);
      return true;
    } elseif ($stmt->rowcount() == 0) {
      echo json_encode("FAIL");
      return false;
    } else {
      printf("Error: %s.\n", $stmt->error);
    }
  }

  //************************************************************* */
  //***** UPDAT Location Any Teir ***** */
  public function updateLocation($mainID, $locationID, $name, $locArr)
  {
    $photoQuery = "";
    $descriptionQuery = "";

    if (array_key_exists(":description", $locArr)) {
      $descriptionQuery = ", Description = :description";
    }
    if (array_key_exists(":photo", $locArr)) {
      $photoQuery = ", Photo = :photo";
    }
    $query =
      "UPDATE Location SET Name = :name " .
      $photoQuery .
      $descriptionQuery .
      " WHERE MainLocationID = :mainID AND LocationID = :locationID";

    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(":name", $name);
    $stmt->bindParam(":mainID", $mainID);
    $stmt->bindParam(":locationID", $locationID);
    foreach ($locArr as $key => $value) {
      $stmt->bindValue($key, $value); // Bug in bindParam
    }
    $stmt->execute();
    if ($stmt->rowcount() > 0) {
      // echo json_encode("UPDATED");
      return true;
    } elseif ($stmt->rowcount() == 0) {
      // echo json_encode("FAIL");
      return false;
    } else {
      printf("Error: %s.\n", $stmt->error);
    }
  }
  //************************************************************* */
  //***** CHECK Top Location to NOT MOVE ***** */
  /* public function checkTopLocation($mainID, $currLocID, $newTopID)
  {
    $query =
      "SELECT TopLocationID FROM Location WHERE LocationID = :newTopID AND MainLocationID = :mainID";
    $temp = $newTopID;
    do {
      $stmt = $this->conn->prepare($query);
      $stmt->bindParam(":mainID", $mainID);
      $stmt->bindParam(":newTopID", $temp);
      $stmt->execute();
      if ($stmt->rowcount() > 0) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $temp = $row["TopLocationID"];
        // echo "Top Location Found...: " . $row["TopLocationID"];
        if ($temp == $currLocID) {
          echo "LOOP ERROR!!!\n";
          return false;
        }
      } elseif ($stmt->rowcount() == 0) {
        echo "NO TOP LOCATION FOUND\n";
        return false;
      } else {
        printf("Error: %s.\n", $stmt->error);
      }
    } while ($temp != null);
    echo "WHILE Loop End...\n";
    return true;
  } */
  //************************************************************* */
  //***** CHECK Top Location to NOT MOVE ***** */
  public function checkLocationLoop($mainID, $currLocID, $newTopID)
  {
    $query = "WITH RECURSIVE name_tree AS (
      SELECT LocationID, TopLocationID, Name
      FROM Location
      WHERE LocationID = :newTopID AND MainLocationID = :mainID
      UNION ALL
      SELECT c.LocationID, c.TopLocationID, c.Name
      FROM Location c
      INNER JOIN name_tree p on p.TopLocationID = c.LocationID AND MainLocationID = :mainID)
      SELECT * FROM name_tree WHERE TopLocationID = :currLocID";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(":mainID", $mainID);
    $stmt->bindParam(":newTopID", $newTopID);
    $stmt->bindParam(":currLocID", $currLocID);
    $stmt->execute();
    if ($stmt->rowcount() > 0) {
      return true;
    } elseif ($stmt->rowcount() == 0) {
      return false;
    } else {
      printf("Error: %s.\n", $stmt->error);
    }
  }
  //************************************************************* */
  //***** UPDAT Top Location ***** */
  public function moveLocation($mainID, $locationID, $newTopID)
  {
    if ($this->checkLocationLoop($mainID, $locationID, $newTopID)) {
      echo json_encode("LOOP");
      return false;
    }
    $query = "UPDATE Location SET TopLocationID = :newTopID 
    WHERE MainLocationID = :mainID AND LocationID = :locationID";

    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(":mainID", $mainID);
    $stmt->bindParam(":locationID", $locationID);
    if ($newTopID == 0) {
      $newTopID = null;
    }
    $stmt->bindParam(":newTopID", $newTopID);
    $stmt->execute();
    if ($stmt->rowcount() > 0) {
      echo json_encode("MOVED");
      return true;
    } elseif ($stmt->rowcount() == 0) {
      echo json_encode("FAIL");
      return false;
    } else {
      printf("Error: %s.\n", $stmt->error);
    }
  }

  //************************************************************* */
  //***** DELETE Location ***** */
  public function deleteLocation($mainID, $locationID)
  {
    $query =
      "DELETE FROM Location WHERE MainLocationID = :mainID AND LocationID = :locationID";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(":mainID", $mainID);
    $stmt->bindParam(":locationID", $locationID);
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

  //************************************************************* */
  //***** Check ACCESS of Main Locaiton ***** */
  public function checkAccess($mainID, $access)
  {
    $query = "SELECT 1 FROM SharedLocation 
    WHERE SharedUserID = :id AND MainLocationID = :mainID AND AccessType >= :access";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(":id", $this->id);
    $stmt->bindParam(":mainID", $mainID);
    $stmt->bindParam(":access", $access);
    $stmt->execute();
    if ($stmt->rowcount() > 0) {
      // echo "You Have Access To the Location...\n";
      return true;
    } elseif ($stmt->rowcount() == 0) {
      return false;
    } else {
      printf("Error: %s.\n", $stmt->error);
    }
  }

  //************************************************************* */
  //***** Check Own Location ***** */
  public function checkOwn($mainID)
  {
    $query =
      "SELECT 1 FROM MainLocation WHERE OwnerID = :id AND MainLocationID = :mainID";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(":id", $this->id);
    $stmt->bindParam(":mainID", $mainID);
    $stmt->execute();
    if ($stmt->rowcount() > 0) {
      // echo "You Own the MainLocation...\n";
      return true;
    } elseif ($stmt->rowcount() == 0) {
      return false;
    } else {
      printf("Error: %s.\n", $stmt->error);
    }
  }

  //************************************************* */
  //********* GET Access level to Library SHARE  *** */
  //************************************************* */
  public function getAccess($mainID)
  {
    $query = "SELECT AccessType AS Access FROM SharedLocation 
    WHERE SharedUserID = :id AND MainLocationID = :mainID";

    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(":id", $this->id);
    $stmt->bindParam(":mainID", $mainID);
    $stmt->execute();
    if ($stmt->rowcount() > 0) {
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      return json_encode($row["Access"]);
    } elseif ($stmt->rowcount() == 0) {
      return json_encode(5);
    } else {
      printf("Error: %s.\n", $stmt->error);
    }
  }

  //************************************************************* */
  //***** CHECK Top Location Exists ***** */
  public function checkTopExists($mainID, $topID)
  {
    $query =
      "SELECT 1 FROM Location WHERE MainLocationID = :mainID AND LocationID = :topID";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(":topID", $topID);
    $stmt->bindParam(":mainID", $mainID);
    $stmt->execute();
    if ($stmt->rowcount() > 0) {
      return true;
    } elseif ($stmt->rowcount() == 0) {
      return false;
    } else {
      printf("Error: %s.\n", $stmt->error);
    }
  }
  //************************************************************* */
  //***** GET NEW Location ID to Update Image File Name ***** */
  public function getNewLocID($mainID)
  {
    $query =
      "SELECT Max(LocationID) AS NewLoc FROM Location WHERE MainLocationID = :mainID";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(":mainID", $mainID);
    $stmt->execute();

    if ($stmt->rowcount() > 0) {
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      $this->newLocID = $row["NewLoc"];
      return $row["NewLoc"];
    } elseif ($stmt->rowcount() == 0) {
      echo "CAN'T FIND NEW MAX ID!!!\n";
      return false;
    } else {
      printf("Error: %s.\n", $stmt->error);
    }
  }
  //************************************************************* */
  //***** GET Link List of Location ***** */
  //!!!!!! Owner and Sharer not Checked !!!!!!!!
  public function getLinkList($mainID, $locationID)
  {
    $query = "WITH RECURSIVE name_tree AS (
        SELECT LocationID, TopLocationID, Name
        FROM Location
        WHERE LocationID = :locationID AND MainLocationID = :mainID
        UNION ALL
        SELECT c.LocationID, c.TopLocationID, c.Name
        FROM Location c
        INNER JOIN name_tree p on p.TopLocationID = c.LocationID AND MainLocationID = :mainID)
        SELECT * FROM name_tree";

    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(":id", $this->id);
    $stmt->bindParam(":mainID", $mainID);
    $stmt->bindParam(":locationID", $locationID);

    $stmt->execute();
    if ($stmt->rowcount() > 0) {
      $jsonArray = [];
      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        array_push($jsonArray, $row);
      }
      return json_encode($jsonArray);
    } elseif ($stmt->rowcount() == 0) {
      echo json_encode("FAIL");
    } else {
      printf("Error: %s.\n", $stmt->error);
    }
  }

  //************************************************* */
  //********* SEARCH Location in a Main Location *********** */
  //************************************************* */
  public function searchLocation($search, $mainID)
  {
    $query = "SELECT LO.* FROM Location AS LO
    LEFT JOIN SharedLocation AS SL ON SL.MainLocationID = LO.MainLocationID AND SharedUserID = :id
    LEFT JOIN MainLocation AS ML ON ML.MainLocationID = LO.MainLocationID AND OwnerID = :id
    WHERE LO.MainLocationID = :mainID 
    AND (LO.Name LIKE :search OR LO.Description LIKE :search) LIMIT 10";
    $stmt = $this->conn->prepare($query);
    $search = "%" . $search . "%";
    $stmt->bindParam(":search", $search);
    $stmt->bindParam(":mainID", $mainID);
    $stmt->bindParam(":id", $this->id);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
      $jsonArray = [];
      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        array_push($jsonArray, $row);
      }
      echo json_encode($jsonArray);
    } elseif ($stmt->rowCount() == 0) {
      echo json_encode("NO LOCATION");
    } else {
      printf("Error: %s.\n", $stmt->error);
      return "Query ERROR!";
    }
  }
} // END of Class

?>
