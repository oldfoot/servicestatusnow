CREATE DEFINER=`servicestatusnow`@`%` PROCEDURE `sp_core_userauth`(IN pUserLogin varchar(50), IN pUserPassword varchar(50))
BEGIN
	SELECT UserID,Activated
	FROM core_usermaster
	WHERE UserLogin = pUserLogin
	AND AccountStatus = 'Active'
	AND UserPassword = MD5(pUserPassword);
    END