CREATE DEFINER=`servicestatusnow`@`%` PROCEDURE `sp_service_code_icon_browse`()
BEGIN
	SELECT IconName FROM service_icon_master
	ORDER BY IconName;			
    END