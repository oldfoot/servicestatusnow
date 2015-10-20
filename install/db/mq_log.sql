CREATE TABLE `mq_log` (
  `LogID` int(5) NOT NULL AUTO_INCREMENT,
  `MQID` int(5) DEFAULT NULL,
  `Description` varchar(255) DEFAULT NULL,
  `DateTimeLog` datetime DEFAULT NULL,
  PRIMARY KEY (`LogID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1