CREATE TABLE `core_organisation_master` (
  `OrganisationID` int(5) NOT NULL AUTO_INCREMENT,
  `OrganisationName` varchar(255) DEFAULT NULL,
  `DateTimeUpdated` datetime DEFAULT NULL,
  `UserIDUpdated` int(5) DEFAULT NULL,
  `AccountType` varchar(20) DEFAULT 'Free',
  `IsPublic` char(1) DEFAULT 'y',
  PRIMARY KEY (`OrganisationID`)
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=latin1