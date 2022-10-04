<?php
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Content-type:application/json");
header("Access-Control-Allow-Credentials: true");
header("connection:keep-alive");

session_start();
session_destroy();
echo json_encode(0);

/* $arr = [];
 $arr["logout"] = true; */
/* echo json_encode($arr);
header("Location: http://localhost:3000/login");
exit(); */

?>
