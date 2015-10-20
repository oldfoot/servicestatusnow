CREATE DEFINER=`servicestatusnow`@`%` PROCEDURE `sp_userroles_edit`(IN pUserID INT(5),in pRoleID int(5))
BEGIN
	UPDATE userroles
	SET RoleID = pRoleID
	WHERE UserID = pUserID;
    END