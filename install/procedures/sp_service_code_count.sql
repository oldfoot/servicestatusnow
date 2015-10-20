CREATE DEFINER=`servicestatusnow`@`%` PROCEDURE `sp_service_code_count`(IN pOrganisationID INT(5))
BEGIN
	SELECT COUNT(*) AS total
	FROM service_code_master
	WHERE OrganisationID = pOrganisationID;
    END