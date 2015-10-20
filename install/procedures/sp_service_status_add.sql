CREATE DEFINER=`servicestatusnow`@`%` PROCEDURE `sp_service_status_add`(IN pAPIAuthCode VARCHAR(100),IN pServiceID INT(5),IN pServiceCode INT(5),IN pServiceDesc VARCHAR(255))
BEGIN
	SELECT COUNT(*) INTO @count_priv
	FROM core_usermaster a, core_userroles b, core_rolepriv c
	WHERE a.APIAuthCode = pAPIAuthCode
	AND a.UserID = b.UserID
	AND b.RoleID = c.RoleID
	AND c.RolePriv = 'Add Service Status';
	
	IF (@count_priv = 1) THEN
		SELECT UserID INTO @userid FROM core_usermaster WHERE APIAuthCode = pApiAuthCode;
		SELECT COUNT(*) INTO @count_priv1
		FROM service_master a, core_organisation_users b
		WHERE a.ServiceID = pServiceID
		AND a.OrganisationID = b.OrganisationID
		AND b.UserID = pUserID;
		IF (@count_priv1 = 1) THEN
			SELECT COUNT(*) INTO @count_priv2
			FROM service_code_master a, core_organisation_users b
			WHERE a.ServiceCode = pServiceCode
			AND a.OrganisationID = b.OrganisationID
			AND b.UserID = pUserID;
			IF (@count_priv2 = 1) THEN
				INSERT INTO service_status_master(ServiceID,ServiceCode,ServiceDesc,DateTimeUpdated,UserIDUpdated)
				VALUES (pServiceID,pServiceCode,pServiceDesc,SYSDATE(),@userid);
				SELECT LAST_INSERT_ID() AS StatusID;
			ELSE
				SELECT 'Invalid Service Code' AS StatusID;
			END IF;			
		ELSE
			SELECT 'Not Auth 1' AS StatusID;
		END IF;
	ELSE
		SELECT 'Not Auth 2' AS StatusID;
	END IF;
    END