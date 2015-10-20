CREATE DEFINER=`servicestatusnow`@`%` PROCEDURE `sp_service_organisationid_status`(IN pOrganisationID INT(5))
BEGIN
	SELECT b.CategoryName, a.ServiceID, a.ServiceName, d.CodeDesc, d.CodeIcon
	FROM service_master a, service_category_master b, service_status_master c, service_code_master d, core_organisation_master e
	WHERE a.ParentID = 0
	AND a.CategoryID = b.CategoryID
	AND a.ServiceID = c.ServiceID
	AND c.ServiceCode = d.ServiceCode
	AND a.OrganisationID = e.OrganisationID
	AND e.OrganisationID = pOrganisationID
	ORDER BY b.Ordering, a.ServiceName;
END