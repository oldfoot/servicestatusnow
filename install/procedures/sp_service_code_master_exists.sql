CREATE DEFINER=`servicestatusnow`@`%` PROCEDURE `sp_service_code_master_exists`(IN pAPIAuthCode VARCHAR(100),IN pCodeName VARCHAR(255),IN pOrganisationID INT(5))
BEGIN
	SELECT COUNT(*) INTO @count_priv
	FROM core_usermaster a, core_userroles b, core_rolepriv c
	WHERE a.APIAuthCode = pAPIAuthCode
	AND a.UserID = b.UserID
	AND b.RoleID = c.RoleID
	AND c.RolePriv = 'Add Service Code';
	
	IF (@count_priv = 1) THEN
		SELECT CodeName FROM service_code_master 
		WHERE CodeName = pCodeName
		AND OrganisationID = pOrganisationID;
	END IF;	
    END