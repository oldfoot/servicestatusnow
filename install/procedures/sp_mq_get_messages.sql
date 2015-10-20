CREATE DEFINER=`servicestatusnow`@`%` PROCEDURE `sp_mq_get_messages`(IN pType VARCHAR(15))
BEGIN
	SELECT *
	FROM mq_master
	WHERE status = 'new'
	ORDER BY MQID DESC;
    END