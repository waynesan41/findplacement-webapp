<?php

include_once "../../config/Database.php";

class ObjectLocation
{
  private $conn;
  private $id;

  public function __construct($userID)
  {
    $database = new Database();
    $db = $database->connect();
    $this->conn = $db;
    $this->id = $userID;
  }
  //************************************************* */
  //********* GET Object From a Location ************ */
  //************************************************* */
  public function getObjLoc($locID, $mainID, $type)
  {
    $query = "";
    if ($type == 1) {
      $query = "SELECT OB.ObjectID, OB.LibraryID, OB.Name, OB.Photo, OL.Description, OL.Quantity, OL.LastUpdate, UR.FullName FROM ObjectLocation AS OL
      INNER JOIN Objects AS OB
      ON OB.LibraryID = OL.LibraryID AND OB.ObjectID = OL.ObjectID
      LEFT JOIN ObjectLibrary AS LI
      ON LI.LibraryID = OL.LibraryID
      JOIN User AS UR
      ON UR.UserID = OL.EditorID
      WHERE OL.MainLocationID = :mainID AND OL.LocationID = :locID AND LI.OwnerID = :id";
    } else {
      $query = "SELECT OB.ObjectID, OB.LibraryID, OB.Name, OB.Photo, OL.Quantity, OL.Description, OL.LastUpdate, UR.FullName FROM ObjectLocation AS OL
        INNER JOIN Objects AS OB
        ON OB.LibraryID = OL.LibraryID AND OB.ObjectID = OL.ObjectID
        LEFT JOIN SharedLibrary AS SL
        ON OL.LibraryID = SL.ObjectLibraryID
        JOIN User AS UR
      ON UR.UserID = OL.EditorID
        WHERE OL.MainLocationID = :mainID AND OL.LocationID = :locID AND SL.SharedUserID = :id";
    }
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(":id", $this->id);
    $stmt->bindParam(":locID", $locID);
    $stmt->bindParam(":mainID", $mainID);
    $stmt->execute();
    if ($stmt->rowcount() > 0) {
      $jsonArray = [];
      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        array_push($jsonArray, $row);
      }
      return json_encode($jsonArray);
    } elseif ($stmt->rowcount() == 0) {
      echo json_encode("NO OBJECT");
    } else {
      printf("Error: %s.\n", $stmt->error);
    }
  }

  //************************************************* */
  //****** EDIT Object Quantity/Description ********* */
  //************************************************* */
  public function updateObjLoc($locID, $mainID, $objID, $libID, $editArr)
  {
    $quantityQuery = "";
    $descriptionQuery = "";
    if (array_key_exists(":description", $editArr)) {
      $descriptionQuery = ", Description = :description";
    }
    if (array_key_exists(":quantity", $editArr)) {
      $quantityQuery = ", Quantity = :quantity";
    }
    /* $query =
      "UPDATE ObjectLocation SET EditorID = :id" .
      $quantityQuery .
      $descriptionQuery .
      " WHERE  MainLocationID = :mainID AND LocationID = :locID AND ObjectID = :objID AND LibraryID = :libID
      AND (EXISTS (SELECT 1 FROM ObjectLibrary WHERE LibraryID = :libID AND OwnerID = :id) 
      OR EXISTS (SELECT 1 FROM SharedLibrary WHERE ObjectLibraryID = :libID AND SharedUserID = :id))
      AND (EXISTS (SELECT 1 FROM MainLocation WHERE MainLocationID = :mainID AND OwnerID = :id)
      OR EXISTS (SELECT 1 FROM SharedLocation WHERE MainLocationID = :mainID AND SharedUserID = :id))"; */

    $query =
      "UPDATE ObjectLocation SET EditorID = :id" .
      $quantityQuery .
      $descriptionQuery .
      ", LastUpdate = CURRENT_TIMESTAMP() WHERE MainLocationID = :mainID AND LocationID = :locID 
      AND ObjectID = :objID AND LibraryID = :libID";

    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(":id", $this->id);
    $stmt->bindParam(":libID", $libID);
    $stmt->bindParam(":objID", $objID);
    $stmt->bindParam(":locID", $locID);
    $stmt->bindParam(":mainID", $mainID);

    foreach ($editArr as $key => $value) {
      $stmt->bindValue($key, $value); // Bug in bindParam
      // echo json_encode($value);
    }
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

  //************************************************* */
  //********* ADD Object to Location ************ */
  //************************************************* */
  //dataArr[:description, :quantity] ~ Quantity can be 0
  public function addObjLoc($locID, $mainID, $objID, $libID, $editArr)
  {
    $quantityQuery = ["", ""];
    $descriptionQuery = ["", ""];
    if (array_key_exists(":description", $editArr)) {
      $descriptionQuery[0] = ", Description";
      $descriptionQuery[1] = ", :description";
    }
    if (array_key_exists(":quantity", $editArr)) {
      $quantityQuery[0] = ", Quantity";
      $quantityQuery[1] = ", :quantity";
    }
    $query =
      "INSERT IGNORE INTO ObjectLocation (LocationID, MainLocationID, EditorID, ObjectID, LibraryID" .
      $quantityQuery[0] .
      $descriptionQuery[0] .
      ") VALUES (:locID, :mainID, :id, :objID, :libID" .
      $quantityQuery[1] .
      $descriptionQuery[1] .
      ")";

    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(":id", $this->id);
    $stmt->bindParam(":libID", $libID);
    $stmt->bindParam(":objID", $objID);
    $stmt->bindParam(":locID", $locID);
    $stmt->bindParam(":mainID", $mainID);
    foreach ($editArr as $key => $value) {
      $stmt->bindValue($key, $value); // Bug in bindParam
    }
    $stmt->execute();
    if ($stmt->rowcount() > 0) {
      echo json_encode("PLACED");
      return true;
    } elseif ($stmt->rowcount() == 0) {
      echo json_encode("FAIL");
      return false;
    } else {
      printf("Error: %s.\n", $stmt->error);
    }
  }

  //************************************************* */
  //********* DELETE Object from Location *********** */
  //************************************************* */
  public function deleteObjLoc($locID, $mainID, $objID, $libID)
  {
    $query = "DELETE FROM ObjectLocation 
      WHERE LocationID = :locID AND MainLocationID = :mainID 
      AND ObjectID = :objID AND LibraryID = :libID 
      AND (EXISTS (SELECT 1 FROM ObjectLibrary WHERE LibraryID = :libID AND OwnerID = :id) 
      OR EXISTS (SELECT 1 FROM SharedLibrary WHERE ObjectLibraryID = :libID AND SharedUserID = :id))
      AND (EXISTS (SELECT 1 FROM MainLocation WHERE MainLocationID = :mainID AND OwnerID = :id)
      OR EXISTS (SELECT 1 FROM SharedLocation WHERE MainLocationID = :mainID AND SharedUserID = :id))";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(":id", $this->id);
    $stmt->bindParam(":libID", $libID);
    $stmt->bindParam(":objID", $objID);
    $stmt->bindParam(":locID", $locID);
    $stmt->bindParam(":mainID", $mainID);
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

  //************************************************* */
  //*** CHECK Shared Main has same Owner as Library** */
  //************************************************* */
  public function checkMainLibrary($mainID, $libID)
  {
    $query = "SELECT 1 FROM MainLocation AS ML
    JOIN ObjectLibrary  AS OL
    ON ML.OwnerID = OL.OwnerID
    WHERE MainLocationID = :mainID AND LibraryID = :libID";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(":libID", $libID);
    $stmt->bindParam(":mainID", $mainID);
    $stmt->execute();
    if ($stmt->rowcount() > 0) {
      // echo "Owner Match...\n";
      return true;
    } elseif ($stmt->rowcount() == 0) {
      // echo "MAIN OWNER DOESN'T MATCH THE LIBRARY OWNER!!!\n";
      return false;
    } else {
      printf("Error: %s.\n", $stmt->error);
    }
  }

  //************************************************* */
  //********* CHECK Location OWN/SHARE ************ */
  //************************************************* */
  public function checkMainLoc($mainID, $access)
  {
    $queryOwn = "SELECT * FROM MainLocation 
      WHERE OwnerID = :id AND MainLocationID = :mainID";
    $queryShare = "SELECT * FROM SharedLocation 
    WHERE SharedUserID = :id AND MainLocationID = :mainID 
    AND AccessType >= :access";
    $query = "";
    if ($access == 0) {
      $query = $queryOwn;
    } else {
      $query = $queryShare;
    }

    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(":id", $this->id);
    $stmt->bindParam(":mainID", $mainID);
    if ($access != 0) {
      $stmt->bindParam(":access", $access);
    }
    $stmt->execute();
    if ($stmt->rowcount() > 0) {
      // echo "Owner / Shared to this Main Location...\n";
      return true;
    } elseif ($stmt->rowcount() == 0) {
      // echo "ACCESS DENIED TO MAIN LOCATION !!!\n";
      return false;
    } else {
      printf("Error: %s.\n", $stmt->error);
    }
  }

  //************************************************* */
  //********* CHECK Library OWN/SHARE ************ */
  //************************************************* */
  public function checkLibrary($libID, $access)
  {
    $query = "";
    $queryOwn = "SELECT * FROM ObjectLibrary 
    WHERE OwnerId = :id AND LibraryID = :libID";
    $queryShare = "SELECT * FROM SharedLibrary 
    WHERE SharedUserID = :id AND ObjectLibraryID = :libID
    AND AccessType >= :access";
    if ($access == 0) {
      $query = $queryOwn;
    } else {
      $query = $queryShare;
    }
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(":id", $this->id);
    $stmt->bindParam(":libID", $libID);
    if ($access != 0) {
      $stmt->bindParam(":access", $access);
    }
    $stmt->execute();
    if ($stmt->rowcount() > 0) {
      // echo "Owner / Shared to this Library ...\n";
      return true;
    } elseif ($stmt->rowcount() == 0) {
      // echo "ACCESS DENIED TO LIBRARY !!!\n";
      return false;
    } else {
      printf("Error: %s.\n", $stmt->error);
    }
  }
  //************************************************* */
  //********* CHECK Library OWN/SHARE ************ */
  //************************************************* */

  public function getAccessLibrary($mainID, $type)
  {
    $queryOwn = "SELECT LibraryID, Name FROM ObjectLibrary WHERE OwnerID = :id";
    $queryShare = "SELECT OL.LibraryID, OL.Name FROM ObjectLibrary AS OL
    JOIN MainLocation AS ML ON ML.OwnerID = OL.OwnerID AND ML.MainLocationID = :mainID
    JOIN SharedLibrary AS SL ON OL.LibraryID = SL.ObjectLibraryID AND SharedUserID = :id";
    $query = "";

    if ($type == 1) {
      $query = $queryOwn;
    } else {
      $query = $queryShare;
    }
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(":id", $this->id);
    if ($type == 2) {
      $stmt->bindParam(":mainID", $mainID);
    }
    $stmt->execute();
    if ($stmt->rowcount() > 0) {
      $jsonArray = [];
      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        array_push($jsonArray, $row);
      }
      return json_encode($jsonArray);
    } elseif ($stmt->rowcount() == 0) {
      echo json_encode("NO LIBRARY");
      return false;
    } else {
      printf("Error: %s.\n", $stmt->error);
    }
  }
} //END of Class

?>
