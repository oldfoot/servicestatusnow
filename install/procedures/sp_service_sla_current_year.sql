CREATE DEFINER=`servicestatusnow`@`%` PROCEDURE `sp_service_sla_current_year`(IN pOrganisationID INT(5))
BEGIN
SELECT SUM((UNIX_TIMESTAMP(a.DateTimeUpdated) - UNIX_TIMESTAMP(a.DateTimeAdded))) AS diff, b.CodeMeaning,(UNIX_TIMESTAMP(NOW())-UNIX_TIMESTAMP(CONCAT(YEAR(NOW()),'-01-01 00:00:00'))) as seconds_year
FROM service_status_master_log a, service_code_master b
WHERE a.ServiceID IN (SELECT ServiceID FROM service_master WHERE OrganisationID = pOrganisationID)
AND a.DateTimeAdded > CONCAT(year(now()),'-01-01 00:00:00')
AND a.ServiceCode = b.ServiceCode
GROUP BY b.CodeMeaning;
    END