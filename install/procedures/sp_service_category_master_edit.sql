CREATE DEFINER=`servicestatusnow`@`%` PROCEDURE `sp_service_category_master_edit`(IN pAPIAuthCode VARCHAR(100),IN pCategoryID INT(5),IN pCategoryName VARCHAR(255))
BEGIN
	SELECT COUNT(*) INTO @count_priv
	FROM core_usermaster a, core_userroles b, core_rolepriv c
	WHERE a.APIAuthCode = pAPIAuthCode
	AND a.UserID = b.UserID
	AND b.RoleID = c.RoleID
	AND c.RolePriv = 'Edit Service Category';
	
	IF (@count_priv = 1) THEN
		SELECT UserID INTO @userid FROM core_usermaster WHERE APIAuthCode = pApiAuthCode;
		SELECT COUNT(*) INTO @count_priv1
		FROM service_category_master a, core_organisation_users b
		WHERE a.CategoryID = pCategoryID
		AND a.OrganisationID = b.OrganisationID
		AND b.UserID = @userid;
		IF (@count_priv1 = 1) THEN			
			UPDATE service_category_master SET CategoryName = pCategoryName,
			DateTimeUpdated = SysDate(),
			UserIDUpdated = @userid
			WHERE CategoryID = pCategoryID;			
			SELECT 'Success' AS UpdateResult;
		ELSE
			SELECT 'Not Auth 1' AS UpdateResult;
		END IF;
	ELSE
		SELECT 'Not Auth 2' AS UpdateResult;
	END IF;
    END