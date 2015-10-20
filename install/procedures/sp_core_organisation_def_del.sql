CREATE DEFINER=`servicestatusnow`@`%` PROCEDURE `sp_core_organisation_def_del`(IN pUserID INT(5))
BEGIN
	DELETE FROM core_organisation_users
	WHERE UserID = pUserID;
    END