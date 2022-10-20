
<?php
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Origin: http://10.1.10.91:3000");
// header("Access-Control-Allow-Origin: http://localhost:3000");
header("Content-type:application/json");
header("Access-Control-Allow-Credentials: true");
header("connection:keep-alive");
// sleep(1);
session_start();
if (isset($_SESSION["userLogin"])) {
  // echo "USER is Login\n";
  echo json_encode(1);
} else {
  echo json_encode(0);
  die();
}


?>
