CREATE DEFINER=`servicestatusnow`@`%` PROCEDURE `sp_core_organisation_exists`(
	IN pOrganisationName VARCHAR(255)
	)
BEGIN	
	
	SELECT OrganisationID FROM core_organisation_master WHERE OrganisationName = pOrganisationName;
	
    END