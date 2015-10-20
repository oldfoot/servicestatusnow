CREATE DEFINER=`servicestatusnow`@`%` PROCEDURE `sp_usermaster_browse_apiauthcode`(IN pApiAuthCode VARCHAR(100))
BEGIN
SELECT *
					FROM core_usermaster
					WHERE APIAuthCode = pApiAuthCode;
    END