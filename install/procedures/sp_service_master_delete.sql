CREATE DEFINER=`servicestatusnow`@`%` PROCEDURE `sp_service_master_delete`(IN pAPIAuthCode VARCHAR(100),IN pServiceID INT(5))
BEGIN
	SELECT COUNT(*) INTO @count_priv
	FROM core_usermaster a, core_userroles b, core_rolepriv c
	WHERE a.APIAuthCode = pAPIAuthCode
	AND a.UserID = b.UserID
	AND b.RoleID = c.RoleID
	AND c.RolePriv = 'Delete Service Master';
	
	IF (@count_priv = 1) THEN
		SELECT UserID INTO @userid FROM core_usermaster WHERE APIAuthCode = pApiAuthCode;
		SELECT COUNT(*) INTO @count_priv1
		FROM service_master a, core_organisation_users b
		WHERE a.ServiceID = pServiceID
		AND a.OrganisationID = b.OrganisationID
		AND b.UserID = @userid;
		IF (@count_priv1 = 1) THEN
			DELETE FROM service_master WHERE ServiceID = pServiceID;
			SELECT 'Deleted Successfully' AS UpdateResult;			
		ELSE
			SELECT 'Not Auth 1' AS UpdateResult;
		END IF;
	ELSE
		SELECT 'Not Auth 2' AS UpdateResult;
	END IF;
    END