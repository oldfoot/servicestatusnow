CREATE DEFINER=`servicestatusnow`@`%` PROCEDURE `sp_core_usermaster_activate`(IN pCode VARCHAR(100))
BEGIN
	UPDATE core_usermaster
	SET Activated = 'y'
	WHERE ActivationCode = pCode;
	SELECT UserID, UserLogin
	FROM core_usermaster
	WHERE ActivationCode = pCode;
    END