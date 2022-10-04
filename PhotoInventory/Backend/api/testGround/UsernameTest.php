<?php

$username = "aasdf23asdhf2asdfasd";
if (preg_match('/^[A-Z0-9a-z_.]{3,20}$/', $username)) {
    echo "Good!";
} else {
      echo "BAD";
  }

  /* <br />
<b>Warning</b>:  mkdir(): File exists in <b>C:\xampp\htdocs\PhotoInventory\Backend\api\account\signUp.php</b> on line <b>75</b><br />
<br />
<b>Warning</b>:  mkdir(): File exists in <b>C:\xampp\htdocs\PhotoInventory\Backend\api\account\signUp.php</b> on line <b>76</b><br />
<br />
<b>Warning</b>:  mkdir(): File exists in <b>C:\xampp\htdocs\PhotoInventory
\Backend\api\account\signUp.php</b> on line <b>77</b><br /> */

?>