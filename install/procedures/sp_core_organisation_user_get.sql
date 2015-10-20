CREATE DEFINER=`servicestatusnow`@`%` PROCEDURE `sp_core_organisation_user_get`(IN pAPIAuthCode VARCHAR(100),IN pUserID INT(5))
BEGIN
	SELECT count(*) INTO @count_priv
	FROM core_usermaster a, core_userroles b, core_rolepriv c
	WHERE a.APIAuthCode = pAPIAuthCode
	AND a.UserID = b.UserID
	AND b.RoleID = c.RoleID
	AND c.RolePriv = 'Add User To Org';
	
	IF (@count_priv = 1) THEN
		SELECT a.OrganisationID,b.OrganisationName
		FROM core_organisation_users a, core_organisation_master b
		WHERE a.UserID = pUserID
		AND a.UserID IN (SELECT UserID FROM core_usermaster WHERE APIAuthCode = pAPIAuthCode)
		AND a.OrganisationID = b.OrganisationID
		;				
	END IF;
	
	END