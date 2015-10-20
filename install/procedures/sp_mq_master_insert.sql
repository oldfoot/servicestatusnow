CREATE DEFINER=`servicestatusnow`@`%` PROCEDURE `sp_mq_master_insert`(IN pType VARCHAR(15))
BEGIN
	INSERT INTO mq_master (Type,DateTimeInsert) VALUES (pType,sysdate());
	SELECT last_insert_id() as id;
    END