CREATE DEFINER=`servicestatusnow`@`%` PROCEDURE `sp_userrole_priv`(IN pUserID INT(5))
BEGIN
	SELECT rp.*
	FROM rolepriv rp, userroles ur, usermaster um
	WHERE um.UserID = pUserID
	AND um.UserID = ur.UserID
	AND ur.RoleID = rp.RoleID;
    END