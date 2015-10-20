CREATE DEFINER=`servicestatusnow`@`%` PROCEDURE `sp_usermaster_delete`(IN pUserID INT(5))
BEGIN
	UPDATE core_usermaster	
	SET AccountStatus = 'Deleted'
	WHERE UserID = pUserID;
    END