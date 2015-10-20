CREATE DEFINER=`servicestatusnow`@`%` PROCEDURE `sp_userroles_delete`(IN pUserID INT(5))
BEGIN
	DELETE FROM userroles WHERE UserID = pUserID;
    END