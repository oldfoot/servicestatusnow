CREATE DEFINER=`servicestatusnow`@`%` PROCEDURE `sp_core_organisation_master_add`(IN pAPIAuthCode VARCHAR(100),IN pOrganisationName VARCHAR(255))
BEGIN
	SELECT count(*) INTO @count_priv
	FROM core_usermaster a, core_userroles b, core_rolepriv c
	WHERE a.APIAuthCode = pAPIAuthCode
	AND a.UserID = b.UserID
	AND b.RoleID = c.RoleID
	AND c.RolePriv = 'Add Organisation';
	
	IF (@count_priv = 1) THEN
		SELECT UserID INTO @userid FROM core_usermaster WHERE APIAuthCode = pApiAuthCode;
		INSERT INTO core_organisation_master(OrganisationName,DateTimeUpdated,UserIDUpdated) VALUES (pOrganisationName,SYSDATE(),@userid);
		SELECT last_INSERT_ID() INTO @organisationid;
		INSERT INTO core_organisation_users (OrganisationID,UserID,DateTimeUpdated,UserIDUpdated) VALUES (@organisationid,@userid,sysdate(),@userid);
		SELECT @organisationid AS OrganisationID, 'Success' AS ReturnCode;
	ELSE
		SELECT 0 AS OrganisationID, 'Failed to add organisation. Check Privileges.' AS ReturnCode;
	END IF;
	
	END