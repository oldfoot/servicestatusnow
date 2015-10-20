CREATE DEFINER=`servicestatusnow`@`%` PROCEDURE `sp_service_status_codes_browse`(IN pAPIAuthCode VARCHAR(255))
BEGIN
	SELECT ServiceCode, CodeName, CodeDesc, CodeIcon
FROM core_usermaster a, core_organisation_users b, service_code_master c 
WHERE a.APIAuthCode = pAPIAuthCode
AND a.UserID = b.UserID
AND b.OrganisationID = c.OrganisationID;
    END