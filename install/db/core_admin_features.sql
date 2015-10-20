CREATE TABLE `core_admin_features` (
  `ID` int(5) NOT NULL AUTO_INCREMENT,
  `Feature` varchar(25) DEFAULT NULL,
  `FeatureValue` varchar(25) DEFAULT NULL,
  `WikiID` varchar(15) DEFAULT NULL,
  `Category` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1