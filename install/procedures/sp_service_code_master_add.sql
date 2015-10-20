CREATE DEFINER=`servicestatusnow`@`%` PROCEDURE `sp_service_code_master_add`(IN pAPIAuthCode VARCHAR(100),IN pCodeName VARCHAR(25),IN pCodeDesc VARCHAR(255),IN pCodeIcon VARCHAR(50),IN pOrganisationID INT(5),IN pDefaultCode CHAR(1), IN pCodeMeaning VARCHAR(10))
BEGIN
	SELECT COUNT(*) INTO @count_priv
	FROM core_usermaster a, core_userroles b, core_rolepriv c
	WHERE a.APIAuthCode = pAPIAuthCode
	AND a.UserID = b.UserID
	AND b.RoleID = c.RoleID
	AND c.RolePriv = 'Add Service Code';
	
	IF (@count_priv = 1) THEN
		SELECT UserID INTO @userid FROM core_usermaster WHERE APIAuthCode = pApiAuthCode;
		SELECT COUNT(*) INTO @count_priv1
		FROM core_organisation_users
		WHERE OrganisationID = pOrganisationID
		AND UserID = @userid;
		IF (@count_priv1 = 1) THEN			
			INSERT INTO service_code_master(CodeName,CodeDesc,CodeIcon,OrganisationID,DateTimeUpdated,UserIDUpdated,DefaultCode,CodeMeaning)
			VALUES (pCodeName,pCodeDesc,pCodeIcon,pOrganisationID,sysdate(),@userid,pDefaultCode,pCodeMeaning);
			SELECT Last_INSERT_ID() AS ServiceCode;
		ELSE
			SELECT 'Not Auth' AS ServiceCode;
		END IF;
	ELSE
		SELECT 'Not Auth' AS ServiceCode;
	END IF;
    END