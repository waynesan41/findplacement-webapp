<?php

include_once "../../config/Database.php";

class Objects
{
  private $conn;
  private $id;
  public $newObjID;

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
  //================================================= */
  //============ GET Functions ====================== */
  //================================================= */
  //************************************************* */
  //********* Get Objects from a Library ************ */
  //************************************************* */
  public function getObject($libraryID)
  {
    $query = "SELECT OB.* FROM Objects AS OB
      LEFT JOIN ObjectLibrary AS LI 
      ON LI.LibraryID = OB.LibraryID 
      LEFT JOIN SharedLibrary AS SL 
      ON SL.ObjectLibraryID = OB.LibraryID 
      WHERE OB.LibraryID = :libraryID 
      AND (LI.OwnerID = :id OR SL.SharedUserID = :id) 
      GROUP BY ObjectID ORDER BY ObjectID DESC LIMIT 30";

    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(":id", $this->id);
    $stmt->bindParam(":libraryID", $libraryID);
    $stmt->execute();
    if ($stmt->rowcount() > 0) {
      $jsonArray = [];
      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        array_push($jsonArray, $row);
      }
      echo json_encode($jsonArray);
    } elseif ($stmt->rowcount() == 0) {
      echo json_encode("FAIL");
    } else {
      printf("Error: %s.\n", $stmt->error);
    }
  }
  //************************************************* */
  //********* Check Access to Library OWN / SHARE *** */
  //************************************************* */
  public function checkOwn($libraryID)
  {
    $query =
      "SELECT 1 FROM ObjectLibrary WHERE OwnerID = :id AND LibraryID = :libraryID";

    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(":id", $this->id);
    $stmt->bindParam(":libraryID", $libraryID);
    $stmt->execute();
    if ($stmt->rowcount() > 0) {
      return true;
    } elseif ($stmt->rowcount() == 0) {
      return false;
    } else {
      printf("Error: %s.\n", $stmt->error);
    }
  }
  //************************************************* */
  //********* Check Access to Library OWN / SHARE *** */
  //************************************************* */
  public function checkAccess($libraryID, $access)
  {
    $query = "SELECT * FROM SharedLibrary 
    WHERE SharedUserID = :id AND ObjectLibraryID = :libraryID AND AccessType >= :access";

    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(":id", $this->id);
    $stmt->bindParam(":libraryID", $libraryID);
    $stmt->bindParam(":access", $access);
    $stmt->execute();
    if ($stmt->rowcount() > 0) {
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
  public function getAccess($libraryID)
  {
    $query = "SELECT AccessType AS Access FROM SharedLibrary 
      WHERE SharedUserID = :id AND ObjectLibraryID = :libraryID";

    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(":id", $this->id);
    $stmt->bindParam(":libraryID", $libraryID);
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
  //************************************************* */
  //********* ADD NEW Object To Library ************* */
  //************************************************* */
  public function addNewObject($libraryID, $name, $objectArr)
  {
    $photoQuery = ["", ""];
    $descriptionQuery = ["", ""];

    if (array_key_exists(":description", $objectArr)) {
      $descriptionQuery[0] = ", Description";
      $descriptionQuery[1] = ", :description";
    }
    if (array_key_exists(":photo", $objectArr)) {
      $photoQuery[0] = ", Photo";
      $photoQuery[1] = ", :photo";
    }

    $query =
      "INSERT INTO Objects(ObjectID, LibraryID, Name" .
      $photoQuery[0] .
      $descriptionQuery[0] .
      ") VALUES(NULL, :libraryID, :name" .
      $photoQuery[1] .
      $descriptionQuery[1] .
      ")";

    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(":libraryID", $libraryID);
    $stmt->bindParam(":name", $name);
    foreach ($objectArr as $key => $value) {
      $stmt->bindValue($key, $value); // Bug in bindParam use bindValue
    }
    $stmt->execute();
    if ($stmt->rowcount() > 0) {
      // echo "Insert New Object Success!\n";
      $this->getNewObjID($libraryID);
      return true;
    } elseif ($stmt->rowcount() == 0) {
      echo json_encode("FAIL");
      return false;
    } else {
      printf("Error: %s.\n", $stmt->error);
    }
  }
  //************************************************* */
  //********* UPDATE Objects Information  *********** */
  //************************************************* */
  public function updateObject($libraryID, $objectID, $name, $objectArr)
  {
    $photoQuery = "";
    $descriptionQuery = "";

    if (array_key_exists(":description", $objectArr)) {
      $descriptionQuery = ", Description = :description";
    }
    if (array_key_exists(":photo", $objectArr)) {
      $photoQuery = ", Photo = :photo";
    }
    $query =
      "UPDATE Objects SET Name = :name " .
      $photoQuery .
      $descriptionQuery .
      " WHERE ObjectID = :objectID AND LibraryID = :libraryID";

    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(":libraryID", $libraryID);
    $stmt->bindParam(":objectID", $objectID);
    $stmt->bindParam(":name", $name);
    foreach ($objectArr as $key => $value) {
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
  //************************************************* */
  //********* DELETE Object from Library ************ */
  //************************************************* */
  public function deleteObject($libraryID, $objectID)
  {
    // echo "DELETE Object " . $objectID . " in Library: " . $libraryID . "\n";
    $query =
      "DELETE FROM Objects WHERE ObjectID = :objectID AND LibraryID = :libraryID";

    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(":libraryID", $libraryID);
    $stmt->bindParam(":objectID", $objectID);

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
  //************************************************* */
  //********* GET New Object ID *********** */
  //************************************************* */
  public function getNewObjID($libID)
  {
    $query =
      "SELECT Max(ObjectID) AS NewObj FROM Objects WHERE LibraryID = :libID";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(":libID", $libID);
    $stmt->execute();

    if ($stmt->rowcount() > 0) {
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      $this->newObjID = $row["NewObj"];
      return $row["NewObj"];
    } elseif ($stmt->rowcount() == 0) {
      // echo "CAN'T FIND NEW MAX ID!!!\n";
      return false;
    } else {
      printf("Error: %s.\n", $stmt->error);
    }
  }
  //************************************************* */
  //********* SEARCH Objects in a Library *********** */
  //************************************************* */
  public function searchObject($search, $libraryID, $filter)
  {
    $filterQuery = "";
    $filterQuery2 = "";

    if ($filter == 2) {
      $filterQuery = "INNER JOIN ObjectLocation AS JL 
      ON JL.ObjectID = OB.ObjectID AND JL.LibraryID = OB.LibraryID";
    } elseif ($filter == 3) {
      $filterQuery = "LEFT OUTER JOIN ObjectLocation AS JL 
      ON JL.ObjectID = OB.ObjectID AND  JL.LibraryID = OB.LibraryID";
      $filterQuery2 = "AND JL.LocationID IS NULL";
    }

    $query =
      "SELECT OB.* FROM Objects AS OB 
    LEFT JOIN SharedLibrary AS SL ON SL.ObjectLibraryID = OB.LibraryID AND SharedUserID = :id
    LEFT JOIN ObjectLibrary AS OL ON OL.LibraryID = OB.LibraryID AND OwnerID = :id " .
      $filterQuery .
      " WHERE OB.LibraryID = :libraryID AND (OB.Name LIKE :search OR OB.Description LIKE :search) " .
      $filterQuery2 .
      " GROUP BY OB.ObjectID LIMIT 20";
    $stmt = $this->conn->prepare($query);
    $search = "%" . $search . "%";
    $stmt->bindParam(":search", $search);
    $stmt->bindParam(":libraryID", $libraryID);
    $stmt->bindParam(":id", $this->id);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
      $jsonArray = [];
      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        array_push($jsonArray, $row);
      }
      echo json_encode($jsonArray);
    } elseif ($stmt->rowCount() == 0) {
      echo json_encode("NO OBJECT");
    } else {
      printf("Error: %s.\n", $stmt->error);
      return "Query ERROR!";
    }
  }

  //************************************************* */
  //********* Find Location with Search Object *********** */
  //************************************************* */
  public function findLocationWithObject($libraryID, $objectID, $type)
  {
    $typeQuery = "";
    if ($type == 1) {
      $typeQuery = " JOIN MainLocation AS ML ON ML.OwnerID = :id 
      AND LO.MainLocationID = ML.MainLocationID";
    } elseif ($type == 2) {
      $typeQuery = " JOIN SharedLocation AS SL ON SL.SharedUserID = :id 
      AND LO.MainLocationID = SL.MainLocationID";
    }
    $query =
      "SELECT LO.MainLocationID, LO.LocationID, LO.Name, LO.Photo 
    FROM Location AS LO
    JOIN ObjectLocation AS OL 
    ON LO.LocationID = OL.LocationID 
    AND LO.MainLocationID = OL.MainLocationID
    JOIN Objects AS OB 
    ON OL.LibraryID = OB.LibraryID 
    AND OL.ObjectID = OB.ObjectID 
    AND OB.LibraryID = :libraryID
    AND OB.ObjectID = :objectID
    " . $typeQuery;
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(":libraryID", $libraryID);
    $stmt->bindParam(":objectID", $objectID);
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
} //End of Class

?>
