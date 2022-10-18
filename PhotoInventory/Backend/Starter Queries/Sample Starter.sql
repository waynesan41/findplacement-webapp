INSERT IGNORE INTO User(UserID, FullName, Username, Email, Password) VALUES
(1000, 'Dummy User', 'dummyuser1', 'dummy@user.com', 'Qwer`123');

INSERT IGNORE INTO MainLocation(MainLocationID, OwnerID, Name) VALUES
(1000, 1000, 'Dummy Main Location');

INSERT IGNORE INTO ObjectLibrary(LibraryID, OwnerID, Name) VALUES
(1000, 1000, 'Dummy Library');


INSERT IGNORE INTO Connection (UserA, UserB, Status) VALUES
(1001, 1000, 1),
(1001, 1002, 1),
(1001, 1003, 1)
ON DUPLICATE KEY UPDATE Status = 0;

INSERT IGNORE INTO Connection (UserA, UserB, Status) VALUES
(1000, 1001, 1),
(1002, 1001, 1),
(1003, 1001, 1)
ON DUPLICATE KEY UPDATE Status = 1;


INSERT IGNORE INTO SharedLibrary (ObjectLibraryID, SharedUserID, AccessType) VALUES
(1002, 1000, 1), 
(1003, 1000, 2),
(1008, 1000, 3),
(1010, 1000, 3)
ON DUPLICATE KEY UPDATE AccessType = 1;