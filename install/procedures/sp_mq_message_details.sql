CREATE DEFINER=`servicestatusnow`@`%` PROCEDURE `sp_mq_message_details`(IN pMQID INT(5))
BEGIN
SELECT *
	FROM mq_detail
	WHERE MQID = pMQID;
    END