CREATE DEFINER=`servicestatusnow`@`%` PROCEDURE `sp_core_get_organisationid_from_name`(IN pOrganisationName VARCHAR(255))
BEGIN
	sELECT OrganisationID FROM core_organisation_master WHERE OrganisationName = pOrganisationName;
    END