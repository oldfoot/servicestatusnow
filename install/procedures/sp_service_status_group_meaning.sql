CREATE DEFINER=`servicestatusnow`@`%` PROCEDURE `sp_service_status_group_meaning`(IN pOrganisationID INT(5))
BEGIN
	SELECT COUNT(*), c.CodeMeaning
	FROM service_master a, service_status_master b, service_code_master c
	WHERE a.OrganisationID = pOrganisationID
	AND a.ServiceID = b.ServiceID
	AND b.ServiceCode = c.ServiceCode
	GROUP BY c.CodeMeaning;
    END