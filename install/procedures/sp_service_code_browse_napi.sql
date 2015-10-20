CREATE DEFINER=`servicestatusnow`@`%` PROCEDURE `sp_service_code_browse_napi`(IN pOrganisationID INT(5))
BEGIN
	
	SELECT ServiceCode,CodeName,CodeDesc,CodeIcon FROM service_code_master
	WHERE OrganisationID = pOrganisationID
	AND OrganisationID in (SELECT OrganisationID FROM core_organisation_master WHERE IsPublic = 'y');			
		
	
    END