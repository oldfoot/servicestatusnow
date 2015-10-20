CREATE TABLE `service_status_master` (
  `StatusID` int(5) NOT NULL AUTO_INCREMENT,
  `ServiceID` int(5) DEFAULT NULL,
  `ServiceCode` int(5) DEFAULT NULL,
  `ServiceDesc` varchar(255) DEFAULT NULL,
  `DateTimeAdded` datetime DEFAULT NULL,
  `DateTimeUpdated` datetime DEFAULT NULL,
  `UserIDUpdated` int(5) DEFAULT NULL,
  PRIMARY KEY (`StatusID`),
  KEY `FK_service_status_master` (`ServiceID`),
  CONSTRAINT `FK_service_status_master` FOREIGN KEY (`ServiceID`) REFERENCES `service_master` (`ServiceID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=382 DEFAULT CHARSET=latin1