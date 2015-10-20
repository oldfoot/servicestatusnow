CREATE DEFINER=`servicestatusnow`@`%` PROCEDURE `sp_usermaster_pw_reset`(in pCode VARCHAR(100),IN pPass VARCHAR(60))
BEGIN	
	UPDATE usermaster SET UserPassword = md5(pPass) WHERE PasswordResetCode = pCode;	
    END