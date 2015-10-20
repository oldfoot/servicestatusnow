CREATE DEFINER=`servicestatusnow`@`%` PROCEDURE `sp_service_status_browse`(IN pAPIAuthCode VARCHAR(255),IN pServiceID INT(5))
BEGIN
	SELECT COUNT(*) INTO @count_priv
	FROM core_usermaster a, core_userroles b, core_rolepriv c
	WHERE a.APIAuthCode = pAPIAuthCode
	AND a.UserID = b.UserID
	AND b.RoleID = c.RoleID
	AND c.RolePriv = 'Browse Services';
	
	IF (@count_priv = 1) THEN
		SELECT UserID INTO @userid FROM core_usermaster WHERE APIAuthCode = pApiAuthCode;
		SELECT COUNT(*) INTO @count_priv1
		FROM service_master a, core_organisation_users b, core_usermaster c
		WHERE a.ServiceID = pServiceID
		AND a.OrganisationID = b.OrganisationID		
		AND b.UserID = c.UserID	
		AND c.UserID = @userid;
		IF (@count_priv1 = 1) THEN
			SELECT a.StatusID, a. ServiceDesc
			FROM service_status_master a
			WHERE a.ServiceID = pServiceID;			
		ELSE
			SELECT 'Not Auth 1' AS QueryResult;
		END IF;
	ELSE 
		SELECT 'Not Auth 2' as QueryResult;
	END IF;
    END