CREATE TABLE `core_userroles` (
  `UserID` int(5) NOT NULL,
  `RoleID` int(5) NOT NULL DEFAULT '0',
  PRIMARY KEY (`UserID`,`RoleID`),
  KEY `FK_userroles1` (`RoleID`),
  CONSTRAINT `FK_core_userroles` FOREIGN KEY (`UserID`) REFERENCES `core_usermaster` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1