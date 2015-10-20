CREATE TABLE `core_usermaster` (
  `UserID` int(5) NOT NULL AUTO_INCREMENT,
  `UserLogin` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `UserPassword` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `FullName` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `EmailAddress` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `Activated` char(1) CHARACTER SET utf8 DEFAULT 'y',
  `ActivationCode` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `PasswordResetCode` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `ContactDetails` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `AccountStatus` varchar(10) CHARACTER SET utf8 DEFAULT 'Active',
  `DateTimeCreated` datetime DEFAULT NULL,
  `Timezone` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `APIAuthCode` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `LastLogin` datetime DEFAULT NULL,
  `LoginCount` int(5) DEFAULT '0',
  PRIMARY KEY (`UserID`),
  UNIQUE KEY `NewIndex1` (`UserLogin`)
) ENGINE=InnoDB AUTO_INCREMENT=281 DEFAULT CHARSET=latin2