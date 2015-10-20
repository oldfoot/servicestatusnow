CREATE DEFINER=`servicestatusnow`@`%` PROCEDURE `sp_usermaster_pw_change`(in pUserID INT(5),IN pPass VARCHAR(60))
BEGIN	
	UPDATE core_usermaster SET UserPassword = md5(pPass) WHERE UserID = pUserID;	
    END