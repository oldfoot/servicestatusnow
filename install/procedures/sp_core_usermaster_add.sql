CREATE DEFINER=`servicestatusnow`@`%` PROCEDURE `sp_core_usermaster_add`(in pUserLogin VARCHAR(50),
IN pUserPassword VARCHAR(50),IN pFullName VARCHAR(255), IN pActivationCode varchar(100))
BEGIN
	SELECT COUNT(*) INTO @user_exists
	FROM core_usermaster
	WHERE UserLogin = pUserLogin;
	IF (@user_exists = 0) THEN
		INSERT INTO core_usermaster
		(UserLogin,UserPassword,FullName,ActivationCode,DateTimeCreated,APIAuthCode)
		VALUES (pUserLogin,md5(pUserPassword),pFullName,pActivationCode,sysdate(),MD5(CONCAT(sysdate(),pUserPassword,pActivationCode)));
		SELECT last_insert_id() INTO @userid;
		INSERT INTO core_userroles (UserID,RoleID) VALUES (@userid,2);
		SELECT UserID,APIAuthCode FROM core_usermaster WHERE UserID = @userid;
	ELSE
		SELECT 'Not Auth' AS UserID,'Not Auth' AS APIAuthCode;
	END IF;
    END