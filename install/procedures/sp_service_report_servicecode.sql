CREATE DEFINER=`servicestatusnow`@`%` PROCEDURE `sp_service_report_servicecode`(IN pOrganisationID INT(5))
BEGIN
	SELECT a.CodeName, COUNT(*) AS total
	FROM service_code_master a, service_status_master b
	WHERE a.ServiceCode = b.ServiceCode
	AND a.OrganisationID = pOrganisationID
	GROUP BY a.CodeName;
    END