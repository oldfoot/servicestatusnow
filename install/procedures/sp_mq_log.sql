CREATE DEFINER=`servicestatusnow`@`%` PROCEDURE `sp_mq_log`(IN pMQID INT(5), IN pDescription VARCHAR(255))
BEGIN
	INSERT INTO mq_log (MQID,Description,DateTimeLog) VALUES (pMQID,pDescription,sysdate());
	SELECT last_insert_id() AS id;
    END