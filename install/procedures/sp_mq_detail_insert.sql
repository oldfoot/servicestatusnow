CREATE DEFINER=`servicestatusnow`@`%` PROCEDURE `sp_mq_detail_insert`(IN pMQID INT(5),IN pName VARCHAR(255),IN pValue TEXT)
BEGIN
	INSERT INTO mq_detail (MQID,Name,Value) VALUES (pMQID,pName,pValue);
	SELECT last_insert_id() as id;
    END