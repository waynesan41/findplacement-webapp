<?php

/* require_once "../../classes/User.php";
$userObj = new User();

$userObj->setUserID(9);

echo $userObj->getUserID() . "\n";

if ($userObj->checkOldPassword("qwerR`qwe12")) {
  echo "password CORRECT.\n";
} else {
  echo "WRONG Password.\n";
} */

//****************************************************** */
// Filter Functions //
// ***************************************************** */
require_once "../../classes/Filter.php";

$filterObj = new Filter();
/* if ($filterObj->checkUserID(56.5)) {
  echo "True";
} else {
  echo "False";
} */

// ============= Check Library Name =================//
$name = "中文字很多很多幕";
$name1 = "abcde";
$name2 = "a{}s";
if ($filterObj->checklibraryName($name)) {
  echo "True";
} else {
  echo "false";
}
//****************************************************** */
// Connection APIs //
// ***************************************************** */
/* require_once "../../classes/Connection.php";
$connectionObj = new Connection();
$connectionObj->setUserID(6);
 */
// ====== Search User ========= //
// echo $connectionObj->searchUser("a");

// ====== Request To ====== //
// echo $connectionObj->getRequestTo();

// ====== Request From ====== //
// echo $connectionObj->getRequestFrom();

// ====== Get All Connected ====== //
// echo $connectionObj->getConnection();

// ====== Get All Blocked To ===== //
// echo $connectionObj->getBlockTo();

// ====== Update Accept Request ===== //
// echo $connectionObj->acceptRequestFrom(11);

// ====== Check Request FROM ===== //
/* if ($connectionObj->checkRequestFrom(4)) {
  echo "REQUEST From";
} else {
  echo "No Request";
}
*/
// ===== Check Block Users ======//
/* if ($connectionObj->checkBlocked(8)) {
  echo "Blocked!";
} else {
  echo "Not Blocke!";
} */

// ===== Check Requested TO ======= //
/* if ($connectionObj->checkRequestTo(4)) {
  echo "Requested!";
} else {
  echo "Not Requested!";
} */

//======= Check SEND Request =======//
/* $connectionObj->setUserID(7);
 $connectionObj->sendRequestTo(11); */

//======= ACCEPT Request FROM =======//
/* $connectionObj->setUserID(11);
$connectionObj->acceptRequestFrom(7);
 */
// ======= DENY Request FROM ======//
/* $connectionObj->setUserID(11);
 $connectionObj->denyRequestFrom(7); */

// ======= DENY Request FROM ======//
/* $connectionObj->setUserID(11);
 $connectionObj->cancelRequestTo(7); */

// ======= DISCONNECT With ==========//
/* $connectionObj->setUserID(7);
 $connectionObj->disconnectWith(11); */

//========== BLOCK User ===========//
/* $connectionObj->setUserID(7);
$connectionObj->blockUser(9);
 */
//**************************************************** */
// Library APIs //
// *************************************************** */
// require_once "../../classes/Library.php";
// $libraryObj = new Library();
// $libraryObj->setUserID(6);

//========== GET Library =============//
// echo $libraryObj->getOwnLibrary();
// echo $libraryObj->getSharedLibrary();
// echo $libraryObj->getShareLibarary();

//========= Check Library Name =========//
/* if ($libraryObj->checkLibraryName("YOOLOO3OO")) {
  echo "Library Name ALready Exists";
} else {
  echo "No Library with the name Found!";
} */

//========== GET Share User in a Library =============//
// echo $libraryObj->getSharedUsers(19);

//=========== GET Owner of the Library ======//
// echo $libraryObj->getOwner(6);

//========= UPDATE Edit Library =========//
// echo $libraryObj->updateLibrary(18, "YOOLOOOO");

//========= INSERT New Library =========//
// echo $libraryObj->addLibrary("weather");

//========= SHARE New Library =========//
// echo $libraryObj->shareLibrary(13, 4, 90);

//========= REMOVE Shared User =========//
// echo $libraryObj->removeShareUser(13, 15);

//========= LEAVING Shared Library =======//
// echo $libraryObj->leaveShareLibrary(23);

//========= DELETE Own LIbrary ========//
// echo $libraryObj->deleteOwnLibrary(26, "Same Name1");
?>
