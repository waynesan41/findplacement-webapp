<?php
session_start();

if (isset($_SESSION["userLogin"])) {
} else {
  echo -1;
  die();
}

?>
