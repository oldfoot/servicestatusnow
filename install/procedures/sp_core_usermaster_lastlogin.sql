CREATE DEFINER=`servicestatusnow`@`%` PROCEDURE `sp_core_usermaster_lastlogin`(in pUserLogin VARCHAR(50))
BEGIN
	UPDATE core_usermaster SET LastLogin = SYSDATE(), LoginCount = LoginCount+1 WHERE UserLogin = pUserLogin;
    END