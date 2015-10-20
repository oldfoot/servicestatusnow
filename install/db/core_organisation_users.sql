CREATE TABLE `core_organisation_users` (
  `UserID` int(5) NOT NULL DEFAULT '0',
  `OrganisationID` int(5) NOT NULL DEFAULT '0',
  `DateTimeUpdated` datetime DEFAULT NULL,
  `UserIDUpdated` int(5) DEFAULT NULL,
  `OrgRoleID` int(5) DEFAULT NULL,
  `Approved` char(1) DEFAULT 'n',
  PRIMARY KEY (`UserID`,`OrganisationID`),
  KEY `FK_core_organisation_users` (`OrganisationID`),
  CONSTRAINT `FK_core_organisation_users` FOREIGN KEY (`OrganisationID`) REFERENCES `core_organisation_master` (`OrganisationID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1