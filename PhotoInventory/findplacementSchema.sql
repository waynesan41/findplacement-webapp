-- MySQL Script generated by MySQL Workbench
-- Thu Mar 24 19:52:35 2022
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

CREATE SCHEMA IF NOT EXISTS `PhotoInventory`;
USE `PhotoInventory` ;

-- -----------------------------------------------------
-- Table `photoinventory`.`user`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `PhotoInventory`.`User` (
  `UserID` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `FullName` VARCHAR(45) NOT NULL,
  `Username` VARCHAR(35) NOT NULL,
  `Password` VARCHAR(255) NOT NULL,
  `Email` VARCHAR(100) NOT NULL UNIQUE,
  `SignUpDate` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `UnitSystem` TINYINT NOT NULL DEFAULT 1,
  PRIMARY KEY (`UserID`));

-- -----------------------------------------------------
-- Table `photoinventory`.`PasswordToken`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `PhotoInventory`.`PasswordToken` (
  `UserID` INT UNSIGNED NOT NULL,
  `ExpireTime` DATETIME NOT NULL,
  `TokenKey` CHAR(128) NOT NULL UNIQUE,
  
  PRIMARY KEY (`UserID`),
  CONSTRAINT `fk_PasswordToken_user`
    FOREIGN KEY (`UserID`)
    REFERENCES `PhotoInventory`.`User` (`UserID`)
    ON DELETE CASCADE
    ON UPDATE CASCADE);
-- -----------------------------------------------------
-- Table `mydb`.`mainLocation`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `PhotoInventory`.`MainLocation` (
  `MainLocationID` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `OwnerID` INT UNSIGNED NOT NULL,
  `Name` VARCHAR(45) NOT NULL,
  `TotalLocation` INT UNSIGNED NOT NULL DEFAULT 0,
  `TotalLayer` INT UNSIGNED NOT NULL DEFAULT 0,
  `TotalObjectType` INT UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`MainLocationID`),
  CONSTRAINT `fk_MainLocation_user`
    FOREIGN KEY (`OwnerID`)
    REFERENCES `PhotoInventory`.`User` (`UserID`)
    ON DELETE CASCADE
    ON UPDATE CASCADE);


-- -----------------------------------------------------
-- Table `mydb`.`sharedLocation`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `PhotoInventory`.`SharedLocation` (
  `MainLocationID` INT UNSIGNED NOT NULL,
  `SharedUserID` INT UNSIGNED NOT NULL,
  `AccessType` INT(4) NOT NULL DEFAULT 0,
  PRIMARY KEY (`MainLocationID`, `SharedUserID`),
  CONSTRAINT `fk_mainLocation_has_user_mainLocation1`
    FOREIGN KEY (`MainLocationID`)
    REFERENCES `PhotoInventory`.`MainLocation` (`MainLocationID`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_mainLocation_has_user_user1`
    FOREIGN KEY (`SharedUserID`)
    REFERENCES `PhotoInventory`.`User` (`UserID`)
    ON DELETE CASCADE
    ON UPDATE CASCADE);

-- -----------------------------------------------------
-- Table `photoinventory`.`location`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `PhotoInventory`.`Location` (
  `LocationID` INT UNSIGNED NOT NULL,
  `MainLocationID` INT UNSIGNED NOT NULL,
  `TopLocationID` INT UNSIGNED NULL DEFAULT NULL,
  `TotalObjectType` INT UNSIGNED NOT NULL DEFAULT 0,
  `PinOnTop` TINYINT UNSIGNED NOT NULL DEFAULT 0,
  `Name` VARCHAR(45) NOT NULL,
  `Photo` TINYINT(4) NOT NULL DEFAULT 0,
  `Description` VARCHAR(300) NULL DEFAULT NULL,
  PRIMARY KEY (`LocationID`, `MainLocationID`),
  CONSTRAINT `fk_location_MainLocation1`
    FOREIGN KEY (`MainLocationID`)
    REFERENCES `PhotoInventory`.`MainLocation` (`MainLocationID`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_location_location1`
    FOREIGN KEY (`TopLocationID`)
    REFERENCES `PhotoInventory`.`Location` (`LocationID`)
    ON DELETE CASCADE
    ON UPDATE CASCADE);



-- -----------------------------------------------------
-- Table `PhotoInventory`.`Connection`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `PhotoInventory`.`Connection` (
  `UserA` INT UNSIGNED NOT NULL,
  `UserB` INT UNSIGNED NOT NULL,
  `Status` TINYINT NOT NULL DEFAULT 1,
  PRIMARY KEY (`UserA`, `UserB`),
  CONSTRAINT `fk_Connection_User1`
    FOREIGN KEY (`UserA`)
    REFERENCES `PhotoInventory`.`User` (`UserID`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_Connection_User2`
    FOREIGN KEY (`UserB`)
    REFERENCES `PhotoInventory`.`User` (`UserID`)
    ON DELETE CASCADE
    ON UPDATE CASCADE);

-- -----------------------------------------------------
-- Table `PhotoInventory`.`ObjectLibrary`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `PhotoInventory`.`ObjectLibrary` (
  `LibraryID` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `OwnerID` INT UNSIGNED NOT NULL,
  `Name` VARCHAR(45) NOT NULL,
  `TotalObject` INT UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`LibraryID`),
  CONSTRAINT `fk_ObjectLibrary_User1`
    FOREIGN KEY (`OwnerID`)
    REFERENCES `PhotoInventory`.`User` (`UserID`)
    ON DELETE CASCADE
    ON UPDATE CASCADE);


-- -----------------------------------------------------
-- Table `PhotoInventory`.`Objects`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `PhotoInventory`.`Objects` (
  `ObjectID` INT UNSIGNED NOT NULL,
  `LibraryID` INT UNSIGNED NOT NULL,
  `Name` VARCHAR(45) NOT NULL,
  `Photo` TINYINT NOT NULL DEFAULT 0,
  `Description` VARCHAR(300) NULL,
  `AddDate` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ObjectID`, `LibraryID`),
  CONSTRAINT `fk_Objects_ObjectLibrary1`
    FOREIGN KEY (`LibraryID`)
    REFERENCES `PhotoInventory`.`ObjectLibrary` (`LibraryID`)
    ON DELETE CASCADE
    ON UPDATE CASCADE);

-- -----------------------------------------------------
-- Table `PhotoInventory`.`Tags`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `PhotoInventory`.`Tags` (
  `TagID` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `CreatedBy` INT UNSIGNED NOT NULL,
  `TagName` VARCHAR(45) NOT NULL UNIQUE,
  PRIMARY KEY (`TagID`),
  CONSTRAINT `fk_Tags_User1`
    FOREIGN KEY (`CreatedBy`)
    REFERENCES `PhotoInventory`.`User` (`UserID`)
    ON DELETE CASCADE
    ON UPDATE CASCADE);

-- -----------------------------------------------------
-- Table `PhotoInventory`.`ObjectTag`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `PhotoInventory`.`ObjectTag` (
  `TagID` INT UNSIGNED NOT NULL,
  `ObjectID` INT UNSIGNED NOT NULL,
  `LibraryID` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`TagID`, `ObjectID`, `LibraryID`),
  CONSTRAINT `fk_Objects_has_Tags_Tags1`
    FOREIGN KEY (`TagID`)
    REFERENCES `PhotoInventory`.`Tags` (`TagID`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_ObjectTag_Objects1`
    FOREIGN KEY (`ObjectID` , `LibraryID`)
    REFERENCES `PhotoInventory`.`Objects` (`ObjectID` , `LibraryID`)
    ON DELETE CASCADE
    ON UPDATE CASCADE);


-- -----------------------------------------------------
-- Table `PhotoInventory`.`SharedLibrary`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `PhotoInventory`.`SharedLibrary` (
  `ObjectLibraryID` INT UNSIGNED NOT NULL,
  `SharedUserID` INT UNSIGNED NOT NULL,
  `AccessType` TINYINT NOT NULL DEFAULT 0,
  PRIMARY KEY (`ObjectLibraryID`, `SharedUserID`),
  CONSTRAINT `fk_SharedLibrary_ObjectLibrary`
    FOREIGN KEY (`ObjectLibraryID`)
    REFERENCES `PhotoInventory`.`ObjectLibrary` (`LibraryID`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_SharedLibrary_User`
    FOREIGN KEY (`SharedUserID`)
    REFERENCES `PhotoInventory`.`User` (`UserID`)
    ON DELETE CASCADE
    ON UPDATE CASCADE);
    
-- -----------------------------------------------------
-- Table `PhotoInventory`.`ObjectLocation`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `PhotoInventory`.`ObjectLocation` (
  `LocationID` INT UNSIGNED NOT NULL,
  `MainLocationID` INT UNSIGNED NOT NULL,
  `EditorID` INT UNSIGNED NOT NULL,
  `ObjectID` INT UNSIGNED NOT NULL,
  `LibraryID` INT UNSIGNED NOT NULL,
  `Quantity` INT UNSIGNED NOT NULL DEFAULT 0,
  `Description` VARCHAR(100) NULL,
  `LastUpdate` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`LocationID`, `MainLocationID`, `ObjectID`, `LibraryID`),
  CONSTRAINT `fk_ObjectLocation_User`
    FOREIGN KEY (`EditorID`)
    REFERENCES `PhotoInventory`.`User` (`UserID`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_ObjectLocation_Location1`
    FOREIGN KEY (`LocationID` , `MainLocationID`)
    REFERENCES `PhotoInventory`.`Location` (`LocationID` , `MainLocationID`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_ObjectLocation_Objects1`
    FOREIGN KEY (`ObjectID` , `LibraryID`)
    REFERENCES `PhotoInventory`.`Objects` (`ObjectID` , `LibraryID`)
    ON DELETE CASCADE
    ON UPDATE CASCADE);


-- -----------------------------------------------------
-- Table `PhotoInventory`.`UserTracker`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `PhotoInventory`.`UserTracker` (
  `UserID` INT UNSIGNED NOT NULL,
  `LibraryCreated` INT UNSIGNED NOT NULL DEFAULT 0,
  `MainLocationCreated` INT UNSIGNED NOT NULL DEFAULT 0,
  `ObjectEdit` INT UNSIGNED NOT NULL DEFAULT 0,
  `LocationEdit` INT UNSIGNED NOT NULL DEFAULT 0,
  `PasswordReset` INT UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`UserID`),
  CONSTRAINT `fk_UserTracker_User1`
    FOREIGN KEY (`UserID`)
    REFERENCES `PhotoInventory`.`User` (`UserID`)
    ON DELETE CASCADE
    ON UPDATE CASCADE);


-- -----------------------------------------------------
-- Table `PhotoInventory`.`UserSession`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `PhotoInventory`.`UserSession` (
  `UserID` INT UNSIGNED NOT NULL,
  `SESSION` VARCHAR(256) NOT NULL,
  PRIMARY KEY (`UserID`, `SESSION`),
  CONSTRAINT `fk_UserSession_User1`
    FOREIGN KEY (`UserID`)
    REFERENCES `PhotoInventory`.`User` (`UserID`)
    ON DELETE CASCADE
    ON UPDATE CASCADE);


-- -----------------------------------------------------
-- New User Trigger
-- -----------------------------------------------------
DELIMITER $$

CREATE TRIGGER `new_user_setup`
AFTER INSERT ON `PhotoInventory`.`User`
FOR EACH ROW
BEGIN
	INSERT INTO `ObjectLibrary` (`OwnerID`, `Name`) VALUES (NEW.`UserID`, 'Default Library');
    INSERT INTO `MainLocation` (`OwnerID`, `Name`) VALUES (NEW.`UserID`, 'Default Main Location');
    INSERT INTO `UserTracker` (`UserID`) VALUES (New.`UserID`);
END $$

CREATE TRIGGER `insert_new_mainLocation`
AFTER INSERT ON `PhotoInventory`.`MainLocation`
FOR EACH ROW
BEGIN
	-- INSERT INTO `Location` (`MainLocationID`, `Name`, `Description`) VALUES(NEW.`MainLocationID`, 'First Default Location in Main', 'Default Description');
    UPDATE `UserTracker` SET `MainLocationCreated` = `MainLocationCreated` + 1 WHERE `UserID` = New.`OwnerID`;
END $$

CREATE TRIGGER `insert_new_location`
BEFORE INSERT ON `PhotoInventory`.`Location`
FOR EACH ROW
BEGIN
	IF(NEW.`LocationID` IS NULL) THEN
		SET NEW.`LocationID` = (SELECT IFNULL(MAX(`LocationID`), 0) + 1 FROM `Location` WHERE `MainLocationID` =  NEW.`MainLocationID`);
    ELSE
		SET NEW.`LocationID` = NEW.`LocationID`;
    END IF;
    UPDATE `MainLocation` SET `TotalLocation` = `TotalLocation` + 1  WHERE `MainLocationID` = New.`MainLocationID`;
END $$

CREATE TRIGGER `delete_location`
BEFORE DELETE ON `PhotoInventory`.`Location`
FOR EACH ROW
BEGIN
    UPDATE `MainLocation` SET `TotalLocation` = `TotalLocation` - 1 WHERE `MainLocationID` = OLD.`MainLocationID`;
END $$

CREATE TRIGGER `insert_new_object`
BEFORE INSERT ON `PhotoInventory`.`Objects`
FOR EACH ROW
BEGIN
	IF(NEW.`ObjectID` IS NULL) THEN
		SET NEW.`ObjectID` = (SELECT IFNULL(MAX(`ObjectID`), 0) + 1 FROM `Objects` WHERE `LibraryID` = NEW.`LibraryID`);
	ELSE
		SET NEW.`ObjectID` = NEW.`ObjectID`;
    END IF;
    UPDATE `ObjectLibrary` SET `TotalObject` = `TotalObject` + 1 WHERE `LibraryID` = NEW.`LibraryID`;
END $$

CREATE TRIGGER `delete_object`
BEFORE DELETE ON `PhotoInventory`.`Objects`
FOR EACH ROW
BEGIN
    UPDATE `ObjectLibrary` SET `TotalObject` = `TotalObject` - 1 WHERE `LibraryID` = OLD.`LibraryID`;
END $$

CREATE TRIGGER `new_Library_added`
AFTER INSERT ON `PhotoInventory`.`ObjectLibrary`
FOR EACH ROW
BEGIN
	UPDATE `UserTracker` SET `LibraryCreated` = `LibraryCreated` + 1 WHERE `UserID` = New.`OwnerID`;
END $$

CREATE TRIGGER `new_token_created`
BEFORE INSERT ON `PhotoInventory`.`PasswordToken`
FOR EACH ROW
BEGIN
	SET New.`ExpireTime` = CURRENT_TIMESTAMP + INTERVAL '15' MINUTE;
    UPDATE `UserTracker` SET `PasswordReset` = `PasswordReset` + 1 WHERE `UserID` = New.`UserID`;
END $$
CREATE TRIGGER `new_token_update`
BEFORE UPDATE ON `PhotoInventory`.`PasswordToken`
FOR EACH ROW
BEGIN
	SET New.`ExpireTime` = CURRENT_TIMESTAMP + INTERVAL '15' MINUTE;
    UPDATE `UserTracker` SET `PasswordReset` = `PasswordReset` + 1 WHERE `UserID` = New.`UserID`;
END $$


-- CREATE PROCEDURE `update_totalSubLocation` (IN `MainID` INT UNSIGNED, IN `TopID` INT UNSIGNED)
-- BEGIN
-- 	UPDATE `Location` SET `TotalSubLocation` = `TotalSubLocation` + 1 WHERE `TopID` IS NOT NULL AND `MainLocationID` = `MainID` AND `LocationID` = `TopID`;
-- END$$

DELIMITER ;
