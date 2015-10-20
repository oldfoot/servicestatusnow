CREATE TABLE `service_status_master_log` (
  `StatusID` int(5) NOT NULL AUTO_INCREMENT,
  `ServiceID` int(5) DEFAULT NULL,
  `ServiceCode` int(5) DEFAULT NULL,
  `ServiceDesc` varchar(255) DEFAULT NULL,
  `DateTimeAdded` datetime DEFAULT NULL,
  `DateTimeUpdated` datetime DEFAULT NULL,
  `UserIDUpdated` int(5) DEFAULT NULL,
  PRIMARY KEY (`StatusID`)
) ENGINE=InnoDB AUTO_INCREMENT=154 DEFAULT CHARSET=latin1