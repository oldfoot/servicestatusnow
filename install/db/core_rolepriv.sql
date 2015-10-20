CREATE TABLE `core_rolepriv` (
  `RoleID` int(5) NOT NULL,
  `RolePriv` varchar(25) NOT NULL,
  PRIMARY KEY (`RoleID`,`RolePriv`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1