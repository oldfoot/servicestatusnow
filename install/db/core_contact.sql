CREATE TABLE `core_contact` (
  `ContactID` int(5) NOT NULL AUTO_INCREMENT,
  `Details` text,
  `DateTimePosted` datetime DEFAULT NULL,
  `Status` varchar(8) DEFAULT 'new',
  PRIMARY KEY (`ContactID`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1