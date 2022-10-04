<?php

class Filter
{
  //************************************************************* */
  //***** Full Name Check ***** */
  public function checkName($name)
  {
    if (
      iconv_strlen($name) < 1 ||
      iconv_strlen($name) > 30 ||
      strstr($name, "\n")
    ) {
      return true;
    } else {
      return false;
    }
  }
  //************************************************************* */
  //***** Library Name Check ***** */
  public function checkLibraryName($name)
  {
    if (
      iconv_strlen($name) < 1 ||
      iconv_strlen($name) > 30 ||
      strstr($name, "\n")
    ) {
      return false;
    } else {
      return true;
    }
  }
  //************************************************************* */
  //***** Library Name Check ***** */
  public function checkObjectName($name)
  {
    if (
      iconv_strlen($name) < 1 ||
      iconv_strlen($name) > 45 ||
      strstr($name, "\n")
    ) {
      return false;
    } else {
      return true;
    }
  }
  //************************************************************* */
  //***** Library Name Check ***** */
  public function checkSearchObjectName($name)
  {
    if (
      iconv_strlen($name) < 0 ||
      iconv_strlen($name) > 45 ||
      strstr($name, "\n")
    ) {
      return false;
    } else {
      return true;
    }
  }
  //************************************************************* */
  //***** Username Check ***** */
  public function checkUsername($username)
  {
    //Usernames can only use letters, numbers, underscores and periods.
    if (preg_match('/^[0-9a-z_.]{3,35}$/', $username)) {
      return false;
    } else {
      return true;
    }
  }
  //************************************************************* */
  //***** Username Check Search ***** */
  public function checkUsernameSearch($username)
  {
    //Usernames can only use letters, numbers, underscores and periods.
    if (preg_match('/^[0-9a-z_.]{1,35}$/', $username)) {
      return false;
    } else {
      return true;
    }
  }

  //************************************************************* */
  //***** Email Check ***** */
  public function checkEmail($email)
  {
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
      return false;
    } else {
      return true;
    }
  }
  //************************************************************* */
  //***** Password Check ***** */
  public function checkPassword($password)
  {
    if (
      !preg_match(
        "/(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9\s])^.{9,100}/",
        $password
      )
    ) {
      return true;
    } else {
      return false;
    }
  }
  //************************************************************* */
  //***** Unit Value Check ***** */
  public function checkUnit($unit)
  {
    if ($unit == 1 || $unit == 2) {
      return true;
    } else {
      return false;
    }
  }
  //************************************************************* */
  //***** UserID Has To Integer ***** */
  public function checkUserID($userID)
  {
    if (
      is_numeric($userID) &&
      $userID > 0 &&
      floor($userID) == $userID &&
      $userID < PHP_INT_MAX
    ) {
      return true;
    } else {
      return false;
    }
  }
  //************************************************************* */
  //***** UserID Has To Integer ***** */
  public function checkInt($integer)
  {
    if (
      is_numeric($integer) &&
      $integer > 0 &&
      floor($integer) == $integer &&
      $integer < PHP_INT_MAX
    ) {
      return true;
    } else {
      return false;
    }
  }
  public function checkIntZero($topID)
  {
    if (
      is_numeric($topID) &&
      $topID >= 0 &&
      floor($topID) == $topID &&
      $topID < PHP_INT_MAX
    ) {
      return true;
    } else {
      return false;
    }
  }
  //************************************************************* */
  //***** Check Access Value ***** */
  public function checkAccessValue($access)
  {
    if ($access > 0 && $access < 4) {
      return true;
    } else {
      return false;
    }
  }
  //************************************************************* */
  //***** Check Access Value ***** */
  public function checkDescription($description)
  {
    if (iconv_strlen($description) < 1 || iconv_strlen($description) > 300) {
      return false;
    } else {
      return true;
    }
  }
  //************************************************************* */
  //***** Check Access Value ***** */
  public function checkDescriptionUpdate($description)
  {
    if (iconv_strlen($description) > 300) {
      return false;
    } else {
      return true;
    }
  }

  public function checkNumPhoto($numPhoto)
  {
    if ($numPhoto >= 0 && $numPhoto < 6) {
      return true;
    } else {
      return false;
    }
  }

  //************************************************************** */
  //******* Check Type of Library Type [1 or 2] */
  public function checkLibraryType($type)
  {
    if ($type == 1 || $type == 2) {
      return true;
    } else {
      return false;
    }
  }

  //************************************************************** */
  //******* Check Type of Library Type [1 or 2] */
  public function checkType($type)
  {
    if ($type == 1 || $type == 2) {
      return true;
    } else {
      return false;
    }
  }
  //************************************************************** */
  //******* Check Search Filter */
  public function checkSearchFilter($type)
  {
    if ($type < 1 || $type > 3) {
      return true;
    } else {
      return false;
    }
  }
  //************************************************************** */
  //******* Check Search Filter */
  public function checkTokenString($token)
  {
    if (preg_match("/^[a-z0-9]{128}$/", $token)) {
      // '/[^a-z\d]/i' should also work.
      return true;
    } else {
      return false;
    }
  }
} //END OF Filter CLASS

?>
