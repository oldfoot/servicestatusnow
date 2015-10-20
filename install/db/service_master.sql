CREATE TABLE `service_master` (
  `ServiceID` int(5) NOT NULL AUTO_INCREMENT,
  `CategoryID` int(5) DEFAULT NULL,
  `ParentID` int(5) DEFAULT NULL,
  `ServiceName` varchar(255) DEFAULT NULL,
  `OrganisationID` int(5) DEFAULT NULL,
  `DateTimeUpdated` datetime DEFAULT NULL,
  `UserIDUpdated` int(5) DEFAULT NULL,
  `ExpectUpdateFrequency` int(5) DEFAULT NULL,
  PRIMARY KEY (`ServiceID`)
) ENGINE=InnoDB AUTO_INCREMENT=227 DEFAULT CHARSET=latin1