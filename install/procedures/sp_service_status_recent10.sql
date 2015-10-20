CREATE DEFINER=`servicestatusnow`@`%` PROCEDURE `sp_service_status_recent10`(IN pAPIAuthCode VARCHAR(255))
BEGIN
SELECT a.DateTimeAdded, UNIX_TIMESTAMP(a.DateTimeAdded) as unixtime, b.ServiceName
FROM service_status_master a, service_master b, service_code_master c
WHERE a.ServiceID = b.ServiceID
AND a.ServiceCode = c.ServiceCode
AND c.CodeMeaning != 'Available'
AND b.OrganisationID IN 
(
SELECT d.OrganisationID 
FROM core_organisation_master d, core_organisation_users e, core_usermaster f
WHERE d.OrganisationID = e.OrganisationID
AND e.UserID = f.UserID
AND f.APIAuthCode = pAPIAuthCode
)
ORDER BY a.StatusID DESC
LIMIT 10;
    END