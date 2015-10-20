CREATE DEFINER=`servicestatusnow`@`%` PROCEDURE `sp_core_userrole_add`(IN pUserID INT(5),IN pRoleID INT(5))
BEGIN
	REPLACE INTO core_userroles
	(UserID,RoleID)
	VALUES (
	pUserID,
	pRoleID);
    END