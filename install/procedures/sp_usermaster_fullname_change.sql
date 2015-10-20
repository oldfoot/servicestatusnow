CREATE DEFINER=`servicestatusnow`@`%` PROCEDURE `sp_usermaster_fullname_change`(IN pUserID INT(5), IN pFullName VARCHAR(100))
BEGIN
	UPDATE core_usermaster
	SET FullName = pFullName
	WHERE UserID = pUserID;
    END