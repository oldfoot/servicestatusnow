CREATE DEFINER=`servicestatusnow`@`%` PROCEDURE `sp_usermaster_browse`(IN pUserID INT(5))
BEGIN
SELECT *
					FROM core_usermaster
					WHERE UserID = pUserID;
    END