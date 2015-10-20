CREATE DEFINER=`servicestatusnow`@`%` PROCEDURE `sp_usermaster_edit`(IN pUserID INT(5),IN pFullName VARCHAR(100), IN pTimeZone VARCHAR(50))
BEGIN
	UPDATE core_usermaster
	SET FullName = pFullName,
	Timezone = pTimezone
	WHERE UserID = pUserID;
    END