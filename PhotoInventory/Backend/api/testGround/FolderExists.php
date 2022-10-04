<?php
$num = 12;
if (is_dir("../../../../../img/user/" . $num)) {
  echo "Folder Exists..\n";
} else {
  echo "NO FOLDER FOUND..\n";
}

?>
