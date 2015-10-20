CREATE DEFINER=`servicestatusnow`@`%` PROCEDURE `sp_service_category_id_from_name`(IN pAPIAuthCode VARCHAR(100),IN pCategoryName VARCHAR(255),IN pOrganisationID INT(5))
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
			SELECT CategoryID FROM service_category_master 
			WHERE CategoryName = pCategoryName
			AND OrganisationID = pOrganisationID;
		ELSE
			SELECT 'Not Auth' AS CategoryID;
		END IF;
	ELSE
		SELECT 'Not Auth' AS CategoryID;
	END IF;
    END