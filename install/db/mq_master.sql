CREATE TABLE `mq_master` (
  `MQID` int(5) NOT NULL AUTO_INCREMENT,
  `Type` varchar(15) DEFAULT NULL,
  `Status` varchar(10) DEFAULT 'new',
  `DateTimeInsert` datetime DEFAULT NULL,
  `DateTimeStart` datetime DEFAULT NULL,
  `DateTimeEnd` datetime DEFAULT NULL,
  PRIMARY KEY (`MQID`)
) ENGINE=InnoDB AUTO_INCREMENT=90 DEFAULT CHARSET=latin1