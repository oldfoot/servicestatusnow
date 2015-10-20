CREATE DEFINER=`servicestatusnow`@`%` PROCEDURE `sp_service_category_master_add`(IN pAPIAuthCode VARCHAR(100),IN pCategoryName VARCHAR(255),IN pOrganisationID INT(5))
BEGIN
	SELECT COUNT(*) INTO @count_priv
	FROM core_usermaster a, core_userroles b, core_rolepriv c
	WHERE a.APIAuthCode = pAPIAuthCode
	AND a.UserID = b.UserID
	AND b.RoleID = c.RoleID
	AND c.RolePriv = 'Add Service Category';
	
	IF (@count_priv = 1) THEN
		SELECT UserID INTO @userid FROM core_usermaster WHERE APIAuthCode = pApiAuthCode;
		SELECT COUNT(*) INTO @count_priv1
		FROM core_organisation_users
		WHERE OrganisationID = pOrganisationID
		AND UserID = @userid;
		IF (@count_priv1 = 1) THEN
			SELECT IF(MAX(ordering)+1 IS NULL,1,MAX(ordering)+1) INTO @next_order FROM service_category_master WHERE OrganisationID = pOrganisationID;
			INSERT INTO service_category_master(CategoryName,OrganisationID,DateTimeUpdated,UserIDUpdated,Ordering)
			VALUES (pCategoryName,pOrganisationID,sysdate(),@userid,@next_order);
			SELECT Last_INSERT_ID() AS CategoryID;
		ELSE
			SELECT 'Not Auth 1' AS CategoryID;
		END IF;
	ELSE
		SELECT 'Not Auth 2' AS CategoryID;
	END IF;
    END