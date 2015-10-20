CREATE DEFINER=`servicestatusnow`@`%` PROCEDURE `sp_timezones_browse`()
BEGIN
SELECT TimezoneName as Name from core_timezone_master;
    END