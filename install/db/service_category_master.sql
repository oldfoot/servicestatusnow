CREATE TABLE `service_category_master` (
  `CategoryID` int(5) NOT NULL AUTO_INCREMENT,
  `CategoryName` varchar(255) DEFAULT NULL,
  `OrganisationID` int(5) DEFAULT NULL,
  `DateTimeUpdated` datetime DEFAULT NULL,
  `UserIDUpdated` int(5) DEFAULT NULL,
  `Ordering` smallint(2) DEFAULT '1',
  PRIMARY KEY (`CategoryID`),
  UNIQUE KEY `NewIndex1` (`CategoryName`,`OrganisationID`)
) ENGINE=InnoDB AUTO_INCREMENT=100 DEFAULT CHARSET=latin1