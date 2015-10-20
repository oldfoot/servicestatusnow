CREATE TABLE `core_sessions` (
  `SessionID` varchar(255) NOT NULL,
  `SessionData` text,
  `SessionTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`SessionID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1