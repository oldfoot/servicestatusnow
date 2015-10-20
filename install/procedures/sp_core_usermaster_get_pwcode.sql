CREATE DEFINER=`servicestatusnow`@`%` PROCEDURE `sp_core_usermaster_get_pwcode`(IN pCode VARCHAR(100))
BEGIN
	SELECT UserID
	FROM core_usermaster
	WHERE PasswordResetCode = pCode;
    END