CREATE DEFINER=`servicestatusnow`@`%` PROCEDURE `sp_service_organisation_status`(IN pOrganisationName VARCHAR(255))
BEGIN
SELECT b.CategoryName, a.ServiceName, d.CodeDesc, d.CodeIcon
FROM service_master a, service_category_master b, service_status_master c, service_code_master d, core_organisation_master e
WHERE ParentID = 0
AND a.CategoryID = b.CategoryID
AND a.ServiceID = c.ServiceID
AND c.ServiceCode = d.ServiceCode
AND a.OrganisationID = e.OrganisationID
AND e.OrganisationName = pOrganisationName
ORDER BY b.Ordering, a.ServiceName;
    END