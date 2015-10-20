CREATE TABLE `service_code_master` (
  `ServiceCode` int(5) NOT NULL AUTO_INCREMENT,
  `CodeName` varchar(25) DEFAULT NULL,
  `CodeDesc` varchar(255) DEFAULT NULL,
  `CodeIcon` varchar(50) DEFAULT NULL,
  `OrganisationID` int(5) DEFAULT NULL,
  `DateTimeUpdated` datetime DEFAULT NULL,
  `UserIDUpdated` int(5) DEFAULT NULL,
  `DefaultCode` char(1) DEFAULT 'n',
  `CodeMeaning` varchar(12) DEFAULT 'Available',
  PRIMARY KEY (`ServiceCode`),
  UNIQUE KEY `NewIndex1` (`CodeName`,`OrganisationID`)
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=latin1