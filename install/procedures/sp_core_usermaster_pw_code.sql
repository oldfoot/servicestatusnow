CREATE DEFINER=`servicestatusnow`@`%` PROCEDURE `sp_core_usermaster_pw_code`(IN pUserLogin varchar(100), in pCode VARCHAR(100))
BEGIN	
	UPDATE core_usermaster SET PasswordResetCode = pCode WHERE UserLogin = pUserLogin;	
    END