CREATE DEFINER=`servicestatusnow`@`%` PROCEDURE `sp_service_category_master_exists`(IN pAPIAuthCode VARCHAR(100),IN pCategoryName VARCHAR(255),IN pOrganisationID INT(5))
BEGIN
	SELECT COUNT(*) INTO @count_priv
	FROM core_usermaster a, core_userroles b, core_rolepriv c
	WHERE a.APIAuthCode = pAPIAuthCode
	AND a.UserID = b.UserID
	AND b.RoleID = c.RoleID
	AND c.RolePriv = 'Add Service Category';
	
	IF (@count_priv = 1) THEN
		SELECT CategoryID FROM service_category_master 
		WHERE CategoryName = pCategoryName
		AND OrganisationID = pOrganisationID;
	END IF;	
    END