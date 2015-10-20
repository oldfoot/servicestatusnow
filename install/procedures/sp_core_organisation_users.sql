CREATE DEFINER=`servicestatusnow`@`%` PROCEDURE `sp_core_organisation_users`(IN pAPIAuthCode VARCHAR(255), IN pOrganisationID INT(5))
BEGIN
	SELECT a.UserID, a.FullName, c.OrganisationName
	FROM core_usermaster a, core_organisation_users b, core_organisation_master c
	WHERE a.UserID = b.UserID
	AND b.OrganisationID = c.OrganisationID
	AND b.OrganisationID = pOrganisationID
	ORDER BY a.FullName;
    END