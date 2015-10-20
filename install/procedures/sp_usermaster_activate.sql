CREATE DEFINER=`servicestatusnow`@`%` PROCEDURE `sp_usermaster_activate`(IN pCode VARCHAR(100))
BEGIN
	UPDATE core_usermaster
	SET Activated = 'y'
	WHERE ActivationCode = pCode;
	SELECT UserID, UserLogin
	FROM core_usermaster
	WHERE ActivationCode = pCode;
	
	INSERT INTO ozlotto_user_balances (UserID,Credits,DateTimeTopup)
	SELECT UserID,5,sysdate()
	FROM core_usermaster
	WHERE ActivationCode = pCode
	AND UserID IN (SELECT UserID FROM ozlotto_friend_invitations);
    END