CREATE DEFINER=`servicestatusnow`@`%` PROCEDURE `sp_core_org_priv`(IN pUserID INT(5))
BEGIN
	SELECT af.Feature, af.FeatureValue
	FROM core_usermaster um, core_organisation_users ou, core_organisation_master om, core_admin_features af
	WHERE um.UserID = pUserID
	AND um.UserID = ou.UserID
	AND ou.OrganisationID = om.OrganisationID
	AND om.AccountType = af.Category;
    END