CREATE DEFINER=`servicestatusnow`@`%` PROCEDURE `sp_service_master_exists`(IN pAPIAuthCode VARCHAR(100),IN pCategoryID INT(5),IN pParentID INT(5),IN pServiceName VARCHAR(255),IN pOrganisationID INT(5))
BEGIN
	SELECT COUNT(*) INTO @count_priv
	FROM core_usermaster a, core_userroles b, core_rolepriv c
	WHERE a.APIAuthCode = pAPIAuthCode
	AND a.UserID = b.UserID
	AND b.RoleID = c.RoleID
	AND c.RolePriv = 'Add Service';
	
	IF (@count_priv = 1) THEN
		SELECT UserID INTO @userid FROM core_usermaster WHERE APIAuthCode = pApiAuthCode;
		SELECT COUNT(*) INTO @count_priv1
		FROM core_organisation_users
		WHERE OrganisationID = pOrganisationID
		AND UserID = @userid;
		IF (@count_priv1 = 1) THEN			
			SELECT ServiceID
			FROM service_master
			WHERE CategoryID = pCategoryID
			AND ParentID = pParentID
			AND ServiceName = pServiceName
			AND OrganisationID = pOrganisationID;
		ELSE
			SELECT 'Not Auth' As ServiceID;
		END IF;
	ELSE
		SELECT 'Not Auth' AS ServiceID;
	END IF;
    END