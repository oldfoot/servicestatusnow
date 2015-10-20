CREATE DEFINER=`servicestatusnow`@`%` PROCEDURE `sp_usermaster_browse_email`(IN pUserLogin VARCHAR(50))
BEGIN
SELECT *
					FROM core_usermaster
					WHERE UserLogin = pUserLogin;
    END