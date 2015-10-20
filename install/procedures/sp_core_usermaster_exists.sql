CREATE DEFINER=`servicestatusnow`@`%` PROCEDURE `sp_core_usermaster_exists`(
	IN pUserLogin VARCHAR(50)
	)
BEGIN	
	
	SELECT COUNT(*) as Total FROM core_usermaster WHERE UserLogin = pUserLogin;
	
    END